// Scroll fade-in
document.addEventListener('DOMContentLoaded', () => {
  const els = document.querySelectorAll('.fade-up');
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
  }, { threshold: 0.15 });
  els.forEach(el => io.observe(el));

  // Date validation on booking form
  const pickup = document.getElementById('pickup_date');
  const ret = document.getElementById('return_date');
  if (pickup && ret) {
    const today = new Date().toISOString().split('T')[0];
    pickup.min = today;
    pickup.addEventListener('change', () => { ret.min = pickup.value; });
  }
});