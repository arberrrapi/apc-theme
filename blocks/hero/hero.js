// Hero Block - 3D Cube vertical flip functionality
document.addEventListener('DOMContentLoaded', function () {
  // Only run on frontend, not in editor
  if (document.body.classList.contains('wp-admin')) {
    return;
  }
  
  const faces = document.querySelectorAll('.wp-block-apc-hero .cube-face, .hero .cube-face');
  const iconGroups = document.querySelectorAll('.wp-block-apc-hero .hero-icons, .hero .hero-icons');
  
  if (faces.length === 0 || iconGroups.length === 0) {
    return;
  }
  
  const iconClassNames = [
    'cloud-icons',
    'performance-icons',
    'processes-icons',
    'enterprise-icons',
  ];
  let currentIndex = 0;
  let isRotating = false;

  // Initialize - disable transitions temporarily, then set initial states
  faces.forEach((face) => {
    face.style.transition = 'none';
  });

  // Set initial positions
  faces[0].classList.add('active');
  for (let i = 1; i < faces.length; i++) {
    faces[i].classList.add('next');
  }

  // Show initial icons (cloud solutions)  
  const initialIcons = document.querySelector('.wp-block-apc-hero .cloud-icons, .hero .cloud-icons');
  if (initialIcons) {
    initialIcons.classList.add('active');
  }

  // Force reflow to apply positions immediately
  faces[0].offsetHeight;

  // Re-enable transitions after initial positioning
  setTimeout(() => {
    faces.forEach((face) => {
      face.style.transition = '';
    });
  }, 50);

  function showIconsForFace(index) {
    // Hide all icon groups
    iconGroups.forEach((group) => {
      group.classList.remove('active');
    });

    // Show icons for current face
    const targetIcons = document.querySelector('.wp-block-apc-hero .' + iconClassNames[index] + ', .hero .' + iconClassNames[index]);
    if (targetIcons) {
      setTimeout(() => {
        targetIcons.classList.add('active');
      }, 300); // Delay to let cube animation start
    }
  }

  function rotateCube() {
    if (isRotating) return;

    isRotating = true;

    // Get current and next face
    const currentFace = faces[currentIndex];
    const nextIndex = (currentIndex + 1) % faces.length;
    const nextFace = faces[nextIndex];

    // Hide current icons first
    iconGroups.forEach((group) => {
      group.classList.remove('active');
    });

    // Clear all classes from all faces first
    faces.forEach((face) => {
      face.classList.remove('active', 'previous', 'next', 'hidden');
    });

    // Set the current face to animate out
    currentFace.classList.add('previous');

    // Set the next face to animate in
    nextFace.classList.add('active');

    // Set all other faces to next position
    for (let i = 0; i < faces.length; i++) {
      if (i !== currentIndex && i !== nextIndex) {
        faces[i].classList.add('next');
      }
    }

    // Show icons for the new face
    showIconsForFace(nextIndex);

    // Clean up after animation completes
    setTimeout(() => {
      // Temporarily disable transitions to prevent visual glitches
      currentFace.style.transition = 'none';

      // Remove previous and immediately set to next (invisible position)
      currentFace.classList.remove('previous');
      currentFace.classList.add('next');

      // Force a reflow to ensure the position change is applied
      currentFace.offsetHeight;

      // Re-enable transitions after a brief moment
      setTimeout(() => {
        currentFace.style.transition = '';
        isRotating = false;
      }, 50);
    }, 1000);

    currentIndex = nextIndex;
  }

  // Start rotation after initial display
  setInterval(rotateCube, 3000); // Change every 3 seconds
});