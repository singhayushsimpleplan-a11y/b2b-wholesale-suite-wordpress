document.addEventListener('DOMContentLoaded', () => {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const hasGSAP = typeof gsap !== 'undefined';
  if (hasGSAP && typeof ScrollTrigger !== 'undefined') gsap.registerPlugin(ScrollTrigger);

  /* ---------- Page fade-in ---------- */
  requestAnimationFrame(() => document.body.classList.add('ready'));

  /* ---------- Theme toggle (dark / light) ---------- */
  const themeToggle = document.getElementById('theme-toggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const html = document.documentElement;
      const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      html.setAttribute('data-theme', next);
      try { localStorage.setItem('b2bws-theme', next); } catch (e) {}
    });
  }

  /* ---------- Global cursor glow (whole page) ---------- */
  const cursorGlow = document.querySelector('.cursor-glow');
  if (cursorGlow && !reduceMotion && window.matchMedia('(hover: hover)').matches) {
    window.addEventListener('mousemove', (e) => {
      cursorGlow.style.setProperty('--cx', `${e.clientX}px`);
      cursorGlow.style.setProperty('--cy', `${e.clientY}px`);
      cursorGlow.classList.add('is-active');
    }, { passive: true });
    document.addEventListener('mouseleave', () => cursorGlow.classList.remove('is-active'));
  }

  /* ---------- Smooth scroll (Lenis) ---------- */
  let lenis = null;
  if (!reduceMotion && typeof Lenis !== 'undefined') {
    lenis = new Lenis({ duration: 0.8, smoothWheel: true, wheelMultiplier: 1 });
    if (hasGSAP) {
      lenis.on('scroll', ScrollTrigger.update);
      gsap.ticker.add((time) => lenis.raf(time * 1000));
      gsap.ticker.lagSmoothing(0);
    } else {
      function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
      requestAnimationFrame(raf);
    }
  }

  /* ---------- Nav ---------- */
  const nav = document.querySelector('.nav');
  const toggle = document.querySelector('.nav-toggle');
  const links = document.querySelector('.nav-links');
  const setNavState = () => {
    if (!nav) return;
    if (window.scrollY > 10) nav.classList.add('scrolled');
    else nav.classList.remove('scrolled');
  };
  setNavState();
  window.addEventListener('scroll', setNavState, { passive: true });
  if (toggle && links) {
    toggle.addEventListener('click', () => {
      const isOpen = links.classList.toggle('mobile-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  /* ---------- Hero WebGL background ---------- */
  const heroCanvas = document.querySelector('.hero-canvas');
  if (heroCanvas && typeof initHeroBG === 'function') {
    initHeroBG(heroCanvas);
  }

  /* ---------- Card spotlight (mouse-follow glow) ---------- */
  document.querySelectorAll('.card, .mockup, .free-card').forEach((el) => {
    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      el.style.setProperty('--mx', `${e.clientX - rect.left}px`);
      el.style.setProperty('--my', `${e.clientY - rect.top}px`);
    });
  });

  /* ---------- Scroll reveals ---------- */
  if (hasGSAP && typeof ScrollTrigger !== 'undefined') {
    const groups = document.querySelectorAll('[data-reveal-group]');
    groups.forEach((group) => {
      const items = group.children.length ? Array.from(group.children) : [group];
      items.forEach((it) => it.setAttribute('data-reveal', ''));
      gsap.to(items, {
        opacity: 1, y: 0, scale: 1,
        duration: 0.9, ease: 'power3.out', stagger: 0.08,
        scrollTrigger: { trigger: group, start: 'top 85%' }
      });
    });

    document.querySelectorAll('[data-reveal]:not([data-reveal-group] > *)').forEach((el) => {
      gsap.to(el, {
        opacity: 1, y: 0,
        duration: 0.9, ease: 'power3.out',
        scrollTrigger: { trigger: el, start: 'top 88%' }
      });
    });

    document.querySelectorAll('[data-reveal-scale]').forEach((el) => {
      gsap.to(el, {
        opacity: 1, scale: 1,
        duration: 1, ease: 'power3.out',
        scrollTrigger: { trigger: el, start: 'top 85%' }
      });
    });

    /* Hero entrance timeline (no scroll trigger, runs immediately) */
    const heroTl = gsap.timeline({ delay: 0.15 });
    document.querySelectorAll('[data-hero-in]').forEach((el, i) => {
      heroTl.fromTo(el, { opacity: 0, y: 26 }, { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' }, i * 0.12);
    });
  } else {
    document.querySelectorAll('[data-reveal], [data-reveal-scale], [data-hero-in]').forEach((el) => {
      el.style.opacity = 1;
      el.style.transform = 'none';
    });
  }

  /* ---------- Counters ---------- */
  document.querySelectorAll('[data-count]').forEach((el) => {
    const target = parseFloat(el.getAttribute('data-count'));
    const prefix = el.getAttribute('data-prefix') || '';
    const suffix = el.getAttribute('data-suffix') || '';
    const decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);
    const format = (v) => prefix + v.toFixed(decimals) + suffix;
    const run = () => {
      const obj = { val: 0 };
      gsap.to(obj, {
        val: target, duration: 1.4, ease: 'power2.out',
        onUpdate: () => { el.textContent = format(obj.val); }
      });
    };
    if (hasGSAP && typeof ScrollTrigger !== 'undefined') {
      ScrollTrigger.create({ trigger: el, start: 'top 90%', once: true, onEnter: run });
    } else {
      el.textContent = format(target);
    }
  });

  /* ---------- FAQ accordion (GSAP height animation) ---------- */
  document.querySelectorAll('.faq-item').forEach((item) => {
    const q = item.querySelector('.faq-q');
    const a = item.querySelector('.faq-a');
    if (!q || !a) return;
    const inner = a.querySelector('.faq-a-inner');
    if (item.classList.contains('open')) {
      a.style.height = 'auto';
    }
    q.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach((openItem) => {
        if (openItem !== item) {
          openItem.classList.remove('open');
          const oa = openItem.querySelector('.faq-a');
          if (hasGSAP) gsap.to(oa, { height: 0, duration: 0.4, ease: 'power2.inOut' });
          else oa.style.height = '0px';
        }
      });
      if (isOpen) {
        item.classList.remove('open');
        if (hasGSAP) gsap.to(a, { height: 0, duration: 0.4, ease: 'power2.inOut' });
        else a.style.height = '0px';
      } else {
        item.classList.add('open');
        const h = inner.offsetHeight;
        if (hasGSAP) gsap.fromTo(a, { height: 0 }, { height: h, duration: 0.45, ease: 'power2.inOut', onComplete: () => { a.style.height = 'auto'; } });
        else a.style.height = h + 'px';
      }
    });
  });

  if (hasGSAP && typeof ScrollTrigger !== 'undefined') {
    ScrollTrigger.refresh();
  }

  /* ---------- Contact form ---------- */
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    const statusEl = document.getElementById('contact-form-status');
    const submitBtn = contactForm.querySelector('.contact-form-submit');
    const setStatus = (text, cls) => {
      if (!statusEl) return;
      statusEl.textContent = text;
      statusEl.className = 'contact-form-status' + (cls ? ' ' + cls : '');
    };

    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const name = contactForm.querySelector('#cf-name').value.trim();
      const email = contactForm.querySelector('#cf-email').value.trim();
      const message = contactForm.querySelector('#cf-message').value.trim();
      if (!name || !email || !message) return;

      if (window.b2bwsAjax && window.b2bwsAjax.ajaxUrl) {
        submitBtn.disabled = true;
        setStatus('Sending…', '');
        const data = new FormData();
        data.append('action', 'b2bws_contact_submit');
        data.append('nonce', window.b2bwsAjax.nonce);
        data.append('name', name);
        data.append('email', email);
        data.append('message', message);

        fetch(window.b2bwsAjax.ajaxUrl, { method: 'POST', body: data })
          .then((res) => res.json())
          .then((json) => {
            submitBtn.disabled = false;
            if (json && json.success) {
              setStatus("Thanks — we'll get back to you within one business day.", 'is-success');
              contactForm.reset();
            } else {
              setStatus((json && json.data && json.data.message) || 'Something went wrong. Please email us directly.', 'is-error');
            }
          })
          .catch(() => {
            submitBtn.disabled = false;
            setStatus('Something went wrong. Please email us directly.', 'is-error');
          });
      } else {
        const subject = encodeURIComponent('New message from ' + name);
        const body = encodeURIComponent(message + '\n\n— ' + name + ' (' + email + ')');
        setStatus('Opening your email client…', '');
        window.location.href = 'mailto:contact@b2bwholesalesuite.com?subject=' + subject + '&body=' + body;
      }
    });
  }
});
