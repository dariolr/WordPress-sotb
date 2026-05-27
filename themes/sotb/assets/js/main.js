/**
 * Sons of the Beach — Main JS
 * Pure vanilla JS, no dependencies
 */

(function () {
  'use strict';

  /* ============================================================
     1. SCROLL: add .scrolled to body when scroll > 60px
     ============================================================ */
  var scrollThreshold = 60;
  var body = document.body;

  function handleScroll() {
    if (window.scrollY > scrollThreshold) {
      body.classList.add('scrolled');
    } else {
      body.classList.remove('scrolled');
    }
  }

  // Run once on load (page may already be scrolled)
  handleScroll();
  window.addEventListener('scroll', handleScroll, { passive: true });

  /* ============================================================
     2. HAMBURGER NAV TOGGLE
     ============================================================ */
  var hamburger = document.getElementById('navHamburger');
  var navLinks  = document.getElementById('navLinks');
  var overlay   = document.getElementById('navOverlay');

  function openNav() {
    body.classList.add('nav-open');
    if (hamburger) hamburger.setAttribute('aria-expanded', 'true');
    if (overlay)   overlay.setAttribute('aria-hidden', 'false');
    // Prevent body scroll while nav open
    body.style.overflow = 'hidden';
  }

  function closeNav() {
    body.classList.remove('nav-open');
    if (hamburger) hamburger.setAttribute('aria-expanded', 'false');
    if (overlay)   overlay.setAttribute('aria-hidden', 'true');
    body.style.overflow = '';
  }

  if (hamburger) {
    hamburger.addEventListener('click', function () {
      if (body.classList.contains('nav-open')) {
        closeNav();
      } else {
        openNav();
      }
    });
  }

  // Close nav when a link inside it is clicked
  if (navLinks) {
    var links = navLinks.querySelectorAll('a');
    links.forEach(function (link) {
      link.addEventListener('click', function () {
        if (body.classList.contains('nav-open')) {
          closeNav();
        }
      });
    });
  }

  // Close nav when overlay is clicked
  if (overlay) {
    overlay.addEventListener('click', closeNav);
  }

  // Close nav on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && body.classList.contains('nav-open')) {
      closeNav();
      if (hamburger) hamburger.focus();
    }
  });

  /* ============================================================
     3. INTERSECTION OBSERVER: fade-in on scroll
     ============================================================ */
  var fadeEls = document.querySelectorAll('.sotb-fade-in');

  if (fadeEls.length > 0 && 'IntersectionObserver' in window) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.12,
        rootMargin: '0px 0px -40px 0px',
      }
    );

    fadeEls.forEach(function (el) {
      observer.observe(el);
    });
  } else {
    // Fallback: show all immediately for older browsers
    fadeEls.forEach(function (el) {
      el.classList.add('visible');
    });
  }

  /* ============================================================
     4. SMOOTH SCROLL for anchor links
     ============================================================ */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var targetId = this.getAttribute('href');
      if (targetId === '#') return;

      var target = document.querySelector(targetId);
      if (!target) return;

      e.preventDefault();

      var navHeight = parseInt(
        getComputedStyle(document.documentElement).getPropertyValue('--nav-height') || '70',
        10
      );

      var targetTop = target.getBoundingClientRect().top + window.pageYOffset - navHeight - 16;

      window.scrollTo({
        top: targetTop,
        behavior: 'smooth',
      });
    });
  });

  /* ============================================================
     5. CARD STAGGER: add staggered animation delay to grid children
     ============================================================ */
  document.querySelectorAll('.interviews-grid, .pillars-grid').forEach(function (grid) {
    var children = grid.querySelectorAll('.sotb-fade-in');
    children.forEach(function (child, index) {
      // Only set delay if not already set by CSS nth-child
      if (index > 3) {
        child.style.transitionDelay = (index * 0.08) + 's';
      }
    });
  });

})();
