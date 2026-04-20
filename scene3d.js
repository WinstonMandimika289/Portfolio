/**
 * CORE 3D SCENE ENGINE - Winston Portfolio
 * Powered by Three.js + GSAP ScrollTrigger
 *
 * PERFORMANCE NOTES:
 * - Lenis is owned by index.html. Do NOT create a second instance here.
 * - No EffectComposer/UnrealBloomPass — direct render() instead (halves GPU load)
 * - mousemove is rAF-throttled; no per-artifact GSAP tweens
 * - 60fps cap on the animation loop
 */

class Scene3D {
    constructor() {
        this.canvas = document.getElementById('hero-canvas');
        if (!this.canvas) return;

        this.lastFrameTime = 0;
        this.frameInterval = 1000 / 60; // 60fps cap
        this.isVisible     = true;      // paused when hero off-screen

        this.init();
        this.createWorld();
        this.setupScrollAnimations();
        this.addEventListeners();
        this.observeVisibility();
        requestAnimationFrame((t) => this.animate(t));
    }

    init() {
        this.scene  = new THREE.Scene();
        this.camera = new THREE.PerspectiveCamera(
            window.innerWidth < 768 ? 90 : 75,
            window.innerWidth / window.innerHeight,
            0.1, 1000
        );
        this.camera.position.z = 8;

        this.renderer = new THREE.WebGLRenderer({
            canvas: this.canvas,
            alpha: true,
            antialias: false,            // off — saves fill-rate, still looks sharp
            powerPreference: 'high-performance'
        });
        this.renderer.setSize(window.innerWidth, window.innerHeight);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.5)); // cap DPR
    }

    createWorld() {
        // ── Lighting ─────────────────────────────────────────────────
        this.scene.add(new THREE.AmbientLight(0xffffff, 0.4));

        const pt1 = new THREE.PointLight(0xff4500, 5, 100);
        pt1.position.set(10, 10, 10);
        this.scene.add(pt1);

        const pt2 = new THREE.PointLight(0x00f2ff, 3, 100);
        pt2.position.set(-10, -10, 10);
        this.scene.add(pt2);

        // ── Neural Network ───────────────────────────────────────────
        this.neuralNetGroup = new THREE.Group();
        this.scene.add(this.neuralNetGroup);

        const nodeCount     = 120;
        const nodePositions = new Float32Array(nodeCount * 3);
        const nodeColors    = new Float32Array(nodeCount * 3);
        const c1 = new THREE.Color('#ff5625');
        const c2 = new THREE.Color('#00f1fe');

        for (let i = 0; i < nodeCount; i++) {
            nodePositions[i*3]   = (Math.random() - 0.5) * 50;
            nodePositions[i*3+1] = (Math.random() - 0.5) * 50;
            nodePositions[i*3+2] = (Math.random() - 0.5) * 40 - 10;
            const c = Math.random() > 0.5 ? c1 : c2;
            nodeColors[i*3]   = c.r;
            nodeColors[i*3+1] = c.g;
            nodeColors[i*3+2] = c.b;
        }

        const nodeGeo = new THREE.BufferGeometry();
        nodeGeo.setAttribute('position', new THREE.BufferAttribute(nodePositions, 3));
        nodeGeo.setAttribute('color',    new THREE.BufferAttribute(nodeColors, 3));

        this.nodes = new THREE.Points(nodeGeo, new THREE.PointsMaterial({
            size: 0.15,
            vertexColors: true,
            transparent: true,
            opacity: 0.8,
            blending: THREE.AdditiveBlending,
            depthWrite: false
        }));
        this.neuralNetGroup.add(this.nodes);

        // Edges (avoid Vector3 allocations — use raw math)
        const ePts = [], eCols = [];
        for (let i = 0; i < nodeCount; i++) {
            for (let j = i + 1; j < nodeCount; j++) {
                const dx = nodePositions[i*3]   - nodePositions[j*3];
                const dy = nodePositions[i*3+1] - nodePositions[j*3+1];
                const dz = nodePositions[i*3+2] - nodePositions[j*3+2];
                if (dx*dx + dy*dy + dz*dz < 64) { // dist < 8 (squared)
                    ePts.push(
                        nodePositions[i*3], nodePositions[i*3+1], nodePositions[i*3+2],
                        nodePositions[j*3], nodePositions[j*3+1], nodePositions[j*3+2]
                    );
                    const r = nodeColors[i*3], g = nodeColors[i*3+1], b = nodeColors[i*3+2];
                    eCols.push(r,g,b, r,g,b);
                }
            }
        }
        const eGeo = new THREE.BufferGeometry();
        eGeo.setAttribute('position', new THREE.Float32BufferAttribute(ePts, 3));
        eGeo.setAttribute('color',    new THREE.Float32BufferAttribute(eCols, 3));

        this.neuralNetGroup.add(new THREE.LineSegments(eGeo, new THREE.LineBasicMaterial({
            vertexColors: true,
            transparent: true,
            opacity: 0.18,
            blending: THREE.AdditiveBlending,
            depthWrite: false
        })));

        // ── Background Particles ─────────────────────────────────────
        const pCount = 800;
        const pPos   = new Float32Array(pCount * 3);
        for (let i = 0; i < pCount * 3; i++) pPos[i] = (Math.random() - 0.5) * 100;

        const pGeo = new THREE.BufferGeometry();
        pGeo.setAttribute('position', new THREE.BufferAttribute(pPos, 3));

        this.particles = new THREE.Points(pGeo, new THREE.PointsMaterial({
            size: 0.04,
            color: 0xff4500,
            transparent: true,
            opacity: 0.25,
            depthWrite: false
        }));
        this.scene.add(this.particles);
    }

    setupScrollAnimations() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        // Camera flight — scrub 2 = smooth but not laggy
        gsap.timeline({
            scrollTrigger: {
                trigger: 'body',
                start: 'top top',
                end: 'bottom bottom',
                scrub: 2
            }
        })
        .to(this.camera.position, { z: -10, x:   5, y:  -5, duration: 1 })
        .to(this.camera.position, { z: -35, x: -10, y:  10, duration: 2 });
    }

    observeVisibility() {
        // Stop WebGL rendering entirely when the hero canvas is off-screen.
        // This is a huge saving — user scrolling through Projects/Contact
        // no longer burns GPU cycles on the Three.js scene.
        const observer = new IntersectionObserver(
            ([entry]) => { this.isVisible = entry.isIntersecting; },
            { threshold: 0 }
        );
        observer.observe(this.canvas);
    }

    addEventListeners() {
        // Resize
        window.addEventListener('resize', () => {
            this.camera.fov    = window.innerWidth < 768 ? 90 : 75;
            this.camera.aspect = window.innerWidth / window.innerHeight;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // Mousemove: rAF-throttled, one GSAP tween with overwrite
        let ticking = false;
        window.addEventListener('mousemove', (e) => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(() => {
                const x =  (e.clientX / window.innerWidth)  * 2 - 1;
                const y = -(e.clientY / window.innerHeight) * 2 + 1;
                gsap.to(this.neuralNetGroup.rotation, {
                    y: x * 0.12, x: -y * 0.12,
                    duration: 2.5, ease: 'power2.out',
                    overwrite: 'auto'
                });
                ticking = false;
            });
        });
    }

    animate(t = 0) {
        requestAnimationFrame((ts) => this.animate(ts));

        // Don't render when canvas is off-screen (saves full GPU frame cost)
        if (!this.isVisible) return;

        // 60fps cap — skip frame if we haven't hit 16.67ms yet
        if (t - this.lastFrameTime < this.frameInterval) return;
        this.lastFrameTime = t;

        this.particles.rotation.y          += 0.0002;
        this.neuralNetGroup.rotation.y     += 0.0004;
        this.neuralNetGroup.rotation.z     += 0.0001;

        this.renderer.render(this.scene, this.camera);
    }
}

document.addEventListener('DOMContentLoaded', () => { new Scene3D(); });
