<?php

/* Enqueue child-theme stylesheet (Google Fonts import lives inside the CSS) */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'hello-elementor-child-style',
        get_stylesheet_uri(),
        ['hello-elementor-theme-style'],
        wp_get_theme()->get('Version')
    );
}, 20);

/* Scroll-reveal: adds .sotb-visible when element enters viewport */
add_action('wp_footer', function () { ?>
<script>
(function () {
  if (!('IntersectionObserver' in window)) return;
  var obs = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) {
        e.target.classList.add('sotb-visible');
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });
  document.querySelectorAll('.sotb-reveal').forEach(function (el) { obs.observe(el); });
})();
</script>
<?php }, 20);

/* Logo override — replaces the Elementor-managed logo src */
add_action('wp_footer', function () {
    $logo_url = esc_url(get_stylesheet_directory_uri() . '/assets/img/logo-sotb-full-cropped.png');
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      var logo = document.querySelector('.elementor-153 .elementor-element-614b7128 img');
      if (!logo) return;
      logo.src = '<?php echo $logo_url; ?>';
      logo.srcset = '';
      logo.style.width = '260px';
      logo.style.maxWidth = '100%';
      logo.style.height = 'auto';
    });
    </script>
    <?php
}, 99);
