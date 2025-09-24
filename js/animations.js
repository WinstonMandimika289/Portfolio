/* Lightweight IntersectionObserver reveal system + stagger
Add class "reveal" (and optional modifiers like fade, slide-up, scale)
Add data attributes to customize:
- data-anim-threshold (0..1)
- data-anim-delay (ms)
- data-anim-duration (ms) [overrides CSS transition duration]
- data-anim-once ("true" to only animate first time)
- For containers: class "stagger" and optional data-stagger-step (ms)
*/
(() => {
const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
if (prefersReduced) return; // bail entirely


const els = Array.from(document.querySelectorAll('.reveal, .stagger'));
if (!els.length) return;


const io = new IntersectionObserver((entries) => {
for (const entry of entries) {
const el = entry.target;
const once = el.dataset.animOnce === 'true';
if (entry.isIntersecting) {
if (el.classList.contains('stagger')) {
applyStagger(el);
}
el.classList.add('in');
if (once) io.unobserve(el);
} else if (!once) {
el.classList.remove('in');
if (el.classList.contains('stagger')) clearStagger(el);
}
}
}, {
threshold: (el) => Number(el?.dataset?.animThreshold ?? .15)
});


// Polyfill dynamic threshold per element
const _observe = io.observe.bind(io);
io.observe = (el) => {
// monkey-patch per-target threshold by recreating observer per element
const t = Number(el.dataset.animThreshold ?? .15);
const o = new IntersectionObserver((entries) => {
for (const e of entries) {
if (e.isIntersecting) {
if (el.classList.contains('stagger')) applyStagger(el);
el.classList.add('in');
if (el.dataset.animOnce === 'true') o.unobserve(el);
} else if (el.dataset.animOnce !== 'true') {
el.classList.remove('in');
if (el.classList.contains('stagger')) clearStagger(el);
}
}
}, { threshold: t });
o.observe(el);
};


els.forEach((el) => io.observe(el));


function applyStagger(container) {
const children = Array.from(container.children);
const step = Number(container.dataset.staggerStep ?? 80);
children.forEach((child, i) => {
child.style.transitionDelay = `${i * step}ms`;
});
}
function clearStagger(container) {
Array.from(container.children).forEach((child) => {
child.style.transitionDelay = '0ms';
});
}
})();