/* Ambient red/black WebGL hero background (Three.js, fullscreen shader plane). */
(function () {
  function initHeroBG(canvas) {
    if (!canvas || typeof THREE === 'undefined') return;

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion) return;

    var renderer;
    try {
      renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: false });
    } catch (e) { return; }

    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.25));

    var scene = new THREE.Scene();
    var camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);

    var uniforms = {
      uTime: { value: 0 },
      uResolution: { value: new THREE.Vector2(1, 1) },
      uMouse: { value: new THREE.Vector2(0.5, 0.5) }
    };

    var vertexShader = [
      'varying vec2 vUv;',
      'void main() {',
      '  vUv = uv;',
      '  gl_Position = vec4(position, 1.0);',
      '}'
    ].join('\n');

    var fragmentShader = [
      'precision highp float;',
      'uniform float uTime;',
      'uniform vec2 uResolution;',
      'uniform vec2 uMouse;',
      'varying vec2 vUv;',
      '',
      'float wave(vec2 p, float t) {',
      '  return sin(p.x * 3.0 + t) + sin(p.y * 2.5 - t * 1.3) + sin((p.x + p.y) * 2.0 + t * 0.7);',
      '}',
      '',
      'void main() {',
      '  vec2 uv = vUv - 0.5;',
      '  float aspect = uResolution.x / uResolution.y;',
      '  uv.x *= aspect;',
      '',
      '  vec2 mouse = (uMouse - 0.5) * 0.5;',
      '  mouse.x *= aspect;',
      '  vec2 p = uv * 1.7 + mouse * 0.6;',
      '  float t = uTime * 0.15;',
      '',
      '  float n = 0.0;',
      '  n += wave(p * 1.0, t) * 0.5;',
      '  n += wave(p * 2.0 + 3.1, t * 1.4) * 0.25;',
      '  n += wave(p * 4.0 - 1.7, t * 0.8) * 0.15;',
      '  n = n * 0.5 + 0.5;',
      '',
      '  float d = length(uv);',
      '  float vignette = smoothstep(1.2, 0.0, d);',
      '',
      '  vec3 white = vec3(0.995, 0.99, 1.0);',
      '  vec3 purple = vec3(0.75, 0.64, 0.98);',
      '  vec3 red = vec3(1.0, 0.68, 0.63);',
      '  vec3 redBright = vec3(1.0, 0.48, 0.4);',
      '',
      '  vec3 tint = mix(white, purple, smoothstep(0.15, 0.55, n));',
      '  tint = mix(tint, red, smoothstep(0.55, 0.85, n));',
      '  tint = mix(tint, redBright, smoothstep(0.85, 1.0, n) * 0.5);',
      '  vec3 col = mix(white, tint, vignette * 0.75);',
      '',
      '  float grain = fract(sin(dot(vUv * uResolution.xy, vec2(12.9898,78.233))) * 43758.5453);',
      '  col += (grain - 0.5) * 0.012;',
      '',
      '  gl_FragColor = vec4(col, 1.0);',
      '}'
    ].join('\n');

    var material = new THREE.ShaderMaterial({
      uniforms: uniforms,
      vertexShader: vertexShader,
      fragmentShader: fragmentShader,
      depthWrite: false,
      depthTest: false
    });

    var quad = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), material);
    scene.add(quad);

    var mouseTarget = { x: 0.5, y: 0.5 };
    var mouseCurrent = { x: 0.5, y: 0.5 };

    function resize() {
      var w = canvas.clientWidth || canvas.parentElement.clientWidth;
      var h = canvas.clientHeight || canvas.parentElement.clientHeight;
      renderer.setSize(w, h, false);
      uniforms.uResolution.value.set(w, h);
    }

    window.addEventListener('resize', resize);
    resize();

    canvas.parentElement.addEventListener('mousemove', function (e) {
      var rect = canvas.parentElement.getBoundingClientRect();
      mouseTarget.x = (e.clientX - rect.left) / rect.width;
      mouseTarget.y = 1.0 - (e.clientY - rect.top) / rect.height;
    });

    var clock = new THREE.Clock();
    var inView = true;
    var tabVisible = !document.hidden;

    var io = new IntersectionObserver(function (entries) {
      inView = entries[0].isIntersecting;
    }, { threshold: 0 });
    io.observe(canvas);

    document.addEventListener('visibilitychange', function () {
      tabVisible = !document.hidden;
    });

    function tick() {
      requestAnimationFrame(tick);
      if (!inView || !tabVisible) return;
      uniforms.uTime.value = clock.getElapsedTime();
      mouseCurrent.x += (mouseTarget.x - mouseCurrent.x) * 0.04;
      mouseCurrent.y += (mouseTarget.y - mouseCurrent.y) * 0.04;
      uniforms.uMouse.value.set(mouseCurrent.x, mouseCurrent.y);
      renderer.render(scene, camera);
    }
    tick();
  }

  window.initHeroBG = initHeroBG;
})();
