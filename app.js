/**
 * app.js — Portfolio auxiliary logic
 *
 * NOTE: AOS, Lenis, and cursor are all handled in index.html.
 * This file handles: mobile menu, magnetic buttons, anchor scrolling.
 */

// ── Mobile Menu Toggle ────────────────────────────────────────────────────────
// Targets the old markup (if still present). Fails silently if not found.
const legacyMenu      = document.querySelector('#mobile-menu');
const legacyMenuLinks = document.querySelector('.navbar__menu');
if (legacyMenu && legacyMenuLinks) {
    legacyMenu.addEventListener('click', () => {
        legacyMenu.classList.toggle('is-active');
        legacyMenuLinks.classList.toggle('active');
    });
}

// ── Magnetic Button Effect ───────────────────────────────────────────────────
document.querySelectorAll('.magnetic-btn').forEach(btn => {
    btn.addEventListener('mousemove', function(e) {
        const r = btn.getBoundingClientRect();
        const x = e.clientX - r.left - r.width  / 2;
        const y = e.clientY - r.top  - r.height / 2;
        btn.style.transform = `translate(${x * 0.28}px, ${y * 0.45}px)`;
    });
    btn.addEventListener('mouseleave', () => {
        btn.style.transform = 'translate(0,0)';
    });
});

// ── GSAP Reveal Text Animations ──────────────────────────────────────────────
document.querySelectorAll('.reveal-text').forEach(text => {
    const content = text.textContent;
    text.innerHTML = `<span class="reveal-inner" style="display:block;">${content}</span>`;
    gsap.from(text.querySelector('.reveal-inner'), {
        y: '100%',
        duration: 1,
        ease: 'power4.out',
        scrollTrigger: { trigger: text, start: 'top 90%' }
    });
});

// ── Anchor Smooth Scroll ──────────────────────────────────────────────────────
// Lenis has been removed; use native scrollIntoView (already smooth via CSS).
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const selector = this.getAttribute('href');
        if (!selector || selector === '#') return;
        const target = document.querySelector(selector);
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
