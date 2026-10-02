import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.data('portfolioUi', () => ({
    menuOpen: false,
    theme: localStorage.getItem('portfolio-theme') || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
    init() {
        document.documentElement.dataset.theme = this.theme;
    },
    toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('portfolio-theme', this.theme);
        document.documentElement.dataset.theme = this.theme;
    },
}));
Alpine.start();

document.querySelectorAll('main > section').forEach((section) => section.dataset.reveal = '');
document.querySelectorAll('.card').forEach((card) => card.dataset.tilt = '');
const nav = document.querySelector('nav');
const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;
if (!reducedMotion && 'IntersectionObserver' in window) { const observer = new IntersectionObserver((entries, instance) => entries.forEach((entry) => { if (entry.isIntersecting) { entry.target.classList.add('is-visible'); instance.unobserve(entry.target); } }), { threshold: .12 }); document.querySelectorAll('[data-reveal]').forEach((element) => observer.observe(element)); } else document.querySelectorAll('[data-reveal]').forEach((element) => element.classList.add('is-visible'));
const sections = [...document.querySelectorAll('main section[id]')];
if ('IntersectionObserver' in window) { const active = new IntersectionObserver((entries) => entries.forEach((entry) => { if (entry.isIntersecting) { nav?.querySelectorAll('a').forEach((link) => link.removeAttribute('aria-current')); nav?.querySelector(`a[href="#${entry.target.id}"]`)?.setAttribute('aria-current', 'page'); } }), { rootMargin: '-35% 0px -55% 0px' }); sections.forEach((section) => active.observe(section)); }
if (!reducedMotion) { const hero = document.querySelector('.hero'); hero?.addEventListener('pointermove', (event) => { const box = hero.getBoundingClientRect(); hero.querySelector('.container').style.transform = `translate(${(event.clientX - box.left - box.width / 2) * .012}px, ${(event.clientY - box.top - box.height / 2) * .012}px)`; }); hero?.addEventListener('pointerleave', () => { hero.querySelector('.container').style.transform = ''; }); document.querySelectorAll('[data-tilt]').forEach((card) => { card.addEventListener('pointermove', (event) => { const box = card.getBoundingClientRect(); card.style.transform = `perspective(700px) rotateX(${(event.clientY - box.top - box.height / 2) * -.025}deg) rotateY(${(event.clientX - box.left - box.width / 2) * .025}deg)`; }); card.addEventListener('pointerleave', () => { card.style.transform = ''; }); }); }
const skillStatus = document.querySelector('.skill-status'); document.querySelectorAll('.skill').forEach((skill) => skill.addEventListener('click', () => { const selected = skill.getAttribute('aria-pressed') === 'true'; document.querySelectorAll('.skill').forEach((item) => item.setAttribute('aria-pressed', 'false')); skill.setAttribute('aria-pressed', String(!selected)); if (skillStatus) skillStatus.textContent = selected ? 'Select a capability to explore it.' : `${skill.textContent} — ${skill.dataset.level}: ${skill.dataset.description}`; }));
const careerStatus = document.querySelector('.career-status'); document.querySelectorAll('.timeline-item').forEach((role) => role.addEventListener('click', () => { const selected = role.getAttribute('aria-pressed') === 'true'; document.querySelectorAll('.timeline-item').forEach((item) => item.setAttribute('aria-pressed', 'false')); role.setAttribute('aria-pressed', String(!selected)); if (careerStatus) careerStatus.textContent = selected ? 'Select a role to explore it.' : `${role.querySelector('.timeline-title').textContent} — ${role.dataset.description}`; }));
