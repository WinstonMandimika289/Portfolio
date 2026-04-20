/**
 * NEURAL NETWORK HERO 3D - Winston Portfolio
 * An abstract, conceptual 3D experience using Three.js
 */

class NeuralHero {
    constructor() {
        this.container = document.getElementById('Home');
        this.canvas = document.getElementById('hero-canvas');
        if (!this.canvas) return;

        this.scene = new THREE.Scene();
        this.camera = new THREE.PerspectiveCamera(70, window.innerWidth / window.innerHeight, 0.1, 1000);
        this.renderer = new THREE.WebGLRenderer({
            canvas: this.canvas,
            alpha: true,
            antialias: true
        });

        this.renderer.setSize(window.innerWidth, window.innerHeight);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

        this.mouse = new THREE.Vector2(0, 0);
        this.targetMouse = new THREE.Vector2(0, 0);
        this.scrollPercent = 0;

        // Configuration
        this.nodeCount = 150;
        this.connectionDistance = 6;
        this.nodes = [];
        
        this.init();
    }

    init() {
        this.camera.position.z = 20;

        this.createNeuralNetwork();
        this.addEventListeners();
        this.animate();
    }

    createNeuralNetwork() {
        this.group = new THREE.Group();
        this.scene.add(this.group);

        // Create Nodes (Points)
        const geometry = new THREE.SphereGeometry(0.12, 12, 12);
        const material = new THREE.MeshPhongMaterial({ 
            color: 0xff4500,
            emissive: 0xff4500,
            emissiveIntensity: 2
        });

        // Setup lighting for the Phong material
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
        this.scene.add(ambientLight);
        this.light = new THREE.PointLight(0xff4500, 2, 50);
        this.scene.add(this.light);

        for (let i = 0; i < this.nodeCount; i++) {
            const mesh = new THREE.Mesh(geometry, material);
            mesh.position.set(
                (Math.random() - 0.5) * 30,
                (Math.random() - 0.5) * 30,
                (Math.random() - 0.5) * 30
            );
            
            // Random velocity for floating effect
            mesh.userData.velocity = new THREE.Vector3(
                (Math.random() - 0.5) * 0.02,
                (Math.random() - 0.5) * 0.02,
                (Math.random() - 0.5) * 0.02
            );
            mesh.userData.originalPos = mesh.position.clone();

            this.group.add(mesh);
            this.nodes.push(mesh);
        }

        // Create Lines (Connections)
        const lineMaterial = new THREE.LineBasicMaterial({ 
            color: 0xff4500, 
            transparent: true, 
            opacity: 0.2 
        });
        this.lineGeometry = new THREE.BufferGeometry();
        this.lineMesh = new THREE.LineSegments(this.lineGeometry, lineMaterial);
        this.scene.add(this.lineMesh);
    }

    updateLines() {
        const positions = [];
        const opacities = [];

        for (let i = 0; i < this.nodes.length; i++) {
            for (let j = i + 1; j < this.nodes.length; j++) {
                const dist = this.nodes[i].position.distanceTo(this.nodes[j].position);
                
                if (dist < this.connectionDistance) {
                    positions.push(
                        this.nodes[i].position.x, this.nodes[i].position.y, this.nodes[i].position.z,
                        this.nodes[j].position.x, this.nodes[j].position.y, this.nodes[j].position.z
                    );
                }
            }
        }

        this.lineGeometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
        this.lineGeometry.attributes.position.needsUpdate = true;
    }

    addEventListeners() {
        window.addEventListener('mousemove', (e) => {
            this.targetMouse.x = (e.clientX / window.innerWidth) * 2 - 1;
            this.targetMouse.y = -(e.clientY / window.innerHeight) * 2 + 1;
        });

        window.addEventListener('scroll', () => {
            this.scrollPercent = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight);
        });

        window.addEventListener('resize', () => {
            this.camera.aspect = window.innerWidth / window.innerHeight;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(window.innerWidth, window.innerHeight);
        });
    }

    animate() {
        requestAnimationFrame(() => this.animate());

        // Interpolate mouse and scroll
        this.mouse.x += (this.targetMouse.x - this.mouse.x) * 0.05;
        this.mouse.y += (this.targetMouse.y - this.mouse.y) * 0.05;

        // Rotate group based on mouse and scroll
        this.group.rotation.y += 0.002 + this.scrollPercent * 0.01;
        this.group.rotation.x = this.mouse.y * 0.2;
        this.group.rotation.z = this.mouse.x * 0.1;

        // Move camera closer on scroll
        this.camera.position.z = 20 - this.scrollPercent * 40;

        // Animate nodes
        this.nodes.forEach(node => {
            // Apply velocity
            node.position.add(node.userData.velocity);

            // Bounds check
            if (Math.abs(node.position.x) > 15) node.userData.velocity.x *= -1;
            if (Math.abs(node.position.y) > 15) node.userData.velocity.y *= -1;
            if (Math.abs(node.position.z) > 15) node.userData.velocity.z *= -1;

            // Mouse attraction
            const mousePoint = new THREE.Vector3(this.mouse.x * 10, this.mouse.y * 10, 0);
            const distToMouse = node.position.distanceTo(mousePoint);
            if (distToMouse < 5) {
                node.position.lerp(mousePoint, 0.02);
            }
        });

        // Move light with mouse
        if (this.light) {
            this.light.position.x = this.mouse.x * 15;
            this.light.position.y = this.mouse.y * 15;
            this.light.position.z = 10;
        }

        this.updateLines();
        this.renderer.render(this.scene, this.camera);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    new NeuralHero();
});
