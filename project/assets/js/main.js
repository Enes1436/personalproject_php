// Minimal JS for mobile nav toggle
(function(){
  document.addEventListener('DOMContentLoaded', function(){
    var btn = document.querySelector('.nav-toggle');
    var nav = document.getElementById('main-nav');
    if(!btn || !nav) return;
    btn.addEventListener('click', function(){
      var expanded = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', String(!expanded));
      nav.classList.toggle('open');
    });
  });
})();
