// Mobile accordion menu logic
document.addEventListener('DOMContentLoaded', function () {
  function isMobile() {
    return window.innerWidth <= 768;
  }
  const mobileAccordionParents = document.querySelectorAll(
    '.mobile-accordion-parent'
  );
  // --- Drilldown mobile navigation ---
  // We'll build separate full-screen drill panels from the nested markup when mobile menu opens.
  let drillContainer = document.querySelector('.mobile-drillpanels');
  // ensure drill container is attached to body so fixed panels position correctly
  if (!drillContainer) {
    drillContainer = document.createElement('div');
    drillContainer.className = 'mobile-drillpanels';
    document.body.appendChild(drillContainer);
  } else if (drillContainer.parentElement !== document.body) {
    document.body.appendChild(drillContainer);
  }

  function buildDrillPanel(title, items) {
    const panel = document.createElement('div');
    panel.className = 'mobile-drill-panel';
    panel.setAttribute('role', 'dialog');

    const header = document.createElement('div');
    header.className = 'mobile-drill-header';

    const backBtn = document.createElement('button');
    backBtn.className = 'drill-back';
    backBtn.type = 'button';
    backBtn.innerHTML = '&#8592;';

    const hTitle = document.createElement('div');
    hTitle.className = 'drill-title';
    hTitle.textContent = title;

    header.appendChild(backBtn);
    header.appendChild(hTitle);
    panel.appendChild(header);

    const list = document.createElement('ul');
    list.className = 'mobile-drill-list';

    items.forEach((it) => list.appendChild(it));
    panel.appendChild(list);

    // back handler: slide out then remove panel to keep DOM clean
    backBtn.addEventListener('click', () => {
      // Check how many panels exist BEFORE animating
      const allPanels = drillContainer.querySelectorAll('.mobile-drill-panel');
      const isRootPanel = allPanels.length === 1;
      
      panel.style.transform = 'translateX(100%)';
      panel.setAttribute('aria-hidden', 'true');
      
      // after transition ends, remove panel
      const onEnd = () => {
        panel.removeEventListener('transitionend', onEnd);
        if (panel.parentElement) panel.parentElement.removeChild(panel);
        
        // If this was the root panel, just return to the main menu (don't close it)
        // Only close if user explicitly clicks hamburger or clicks outside
        if (isRootPanel) {
          // Just return focus to root menu, keep mobile nav open
          const mobileNav = document.querySelector('.mobile-nav');
          if (mobileNav) {
            const rootMenu = mobileNav.querySelector('.mobile-nav-menu');
            if (rootMenu) rootMenu.focus();
          }
        }
      };
      panel.addEventListener('transitionend', onEnd);
    });

    return panel;
  }

  // Convert existing nested markup into drill panels on demand
  function openDrillFor(parentToggle) {
    const parentLi = parentToggle.closest('.mobile-accordion-parent');
    if (!parentLi) return;

    const title = parentToggle.textContent.trim();
    // Build list items from direct child anchors or nested groups
    const childPanel = parentLi.querySelector(
      ':scope > .mobile-accordion-panel'
    );
    if (!childPanel) return;

    // Create list items
    const items = [];
    // If there are direct links (li > a)
    childPanel.querySelectorAll(':scope > li, :scope > a').forEach((node) => {
      // If node contains its own mobile-accordion-parent, create a drill link that will open a nested drill
      if (node.matches('li.mobile-accordion-parent')) {
        const subToggle = node.querySelector(
          ':scope > .mobile-accordion-toggle'
        );
        const subPanel = node.querySelector(':scope > .mobile-accordion-panel');
        const li = document.createElement('li');
        li.className = 'mobile-drill-item';
        const btn = document.createElement('button');
        btn.className = 'mobile-drill-link';
        btn.type = 'button';
        btn.textContent = subToggle ? subToggle.textContent.trim() : 'More';
        const chev = document.createElement('span');
        chev.className = 'chev';
        chev.innerHTML = '&#8250;';
        btn.appendChild(chev);
        li.appendChild(btn);

        // clicking the item builds and shows a nested panel
        btn.addEventListener('click', () => {
          // create nested items from subPanel children
          const nestedItems = [];
          subPanel
            .querySelectorAll(
              ':scope > li > a, :scope > li > a, :scope > li > .mobile-accordion-toggle'
            )
            .forEach((n) => {
              // prefer anchors
              if (n.tagName === 'A') {
                const nestedLi = document.createElement('li');
                nestedLi.className = 'mobile-drill-item';
                const a = document.createElement('a');
                a.className = 'mobile-drill-link';
                a.href = n.getAttribute('href');
                a.textContent = n.textContent.trim();
                nestedLi.appendChild(a);
                nestedItems.push(nestedLi);
              }
            });
          const nestedPanel = buildDrillPanel(
            btn.textContent.replace('\u203A', '').trim(),
            nestedItems
          );
          drillContainer.appendChild(nestedPanel);
          // position and show nested panel below header/logo
          requestAnimationFrame(() => {
            const headerEl = document.querySelector('.header-container');
            const offset = headerEl
              ? Math.ceil(headerEl.getBoundingClientRect().height)
              : 0;
            nestedPanel.style.top = offset + 'px';
            nestedPanel.style.height = `calc(100% - ${offset}px)`;
            nestedPanel.style.transform = 'translateX(0)';
            nestedPanel.setAttribute('aria-hidden', 'false');
          });
        });

        items.push(li);
      } else {
        // regular link
        const linkEl = node.querySelector ? node.querySelector('a') : null;
        if (node.tagName === 'A' || linkEl) {
          const href =
            node.tagName === 'A'
              ? node.getAttribute('href')
              : linkEl
              ? linkEl.getAttribute('href')
              : '#';
          const text =
            node.tagName === 'A'
              ? node.textContent.trim()
              : linkEl
              ? linkEl.textContent.trim()
              : '';
          const li = document.createElement('li');
          li.className = 'mobile-drill-item';
          const a = document.createElement('a');
          a.className = 'mobile-drill-link';
          a.href = href;
          a.textContent = text;
          li.appendChild(a);
          items.push(li);
        }
      }
    });

    const panel = buildDrillPanel(title, items);
    drillContainer.appendChild(panel);

    // animate into view and position below header/logo
    requestAnimationFrame(() => {
      const headerEl = document.querySelector('.header-container');
      const offset = headerEl
        ? Math.ceil(headerEl.getBoundingClientRect().height)
        : 0;
      panel.style.top = offset + 'px';
      panel.style.height = `calc(100% - ${offset}px)`;
      panel.style.transform = 'translateX(0)';
      panel.setAttribute('aria-hidden', 'false');
    });
  }

  // Hook up taps on root-level toggles (only one level deep from the .mobile-nav-menu)
  document
    .querySelectorAll(
      '.mobile-nav > .mobile-nav-menu > li.mobile-accordion-parent > .mobile-accordion-toggle'
    )
    .forEach((toggle) => {
      toggle.addEventListener('click', function (e) {
        const mobileNavEl = document.querySelector('.mobile-nav');
        const mobileNavOpen =
          mobileNavEl && mobileNavEl.classList.contains('open');
        if (!isMobile() && !mobileNavOpen) return;
        e.preventDefault();

        // Ensure hamburger stays in active state when opening drill panels
        const hamburgerMenu = document.querySelector('.hamburger-menu');
        if (hamburgerMenu) hamburgerMenu.classList.add('active');

        openDrillFor(toggle);
      });
    });

  // For second-level toggles inside the hidden panels we will build nested panels dynamically when their buttons are clicked
  // (We already wire nested creation when generating items in openDrillFor)
  // Optionally close all on resize to desktop
  window.addEventListener('resize', function () {
    if (!isMobile()) {
      mobileAccordionParents.forEach((parent) =>
        parent.classList.remove('open')
      );
    }
  });
});
// Create truly seamless infinite scroll by cloning elements
function initInfiniteScroll() {
  const servicesList = document.querySelector('.services-list');
  if (!servicesList) return;

  const originalServices = Array.from(servicesList.children);

  // Clone the original services to create seamless repetition
  originalServices.forEach((service) => {
    const clone = service.cloneNode(true);
    servicesList.appendChild(clone);
  });

  const allServices = Array.from(servicesList.children);
  const itemHeight = 85; // Height + gap
  const containerHeight = 400;
  let scrollPosition = 0;
  let scrollInterval;

  function updateScroll() {
    scrollPosition -= 1; // Speed of scroll

    allServices.forEach((item, index) => {
      let yPosition = scrollPosition + index * itemHeight;

      // When an item goes above the container, move it to the bottom
      if (yPosition < -itemHeight) {
        yPosition += allServices.length * itemHeight;
      }

      // Update position using CSS custom property to avoid transform conflicts
      item.style.setProperty('--scroll-y', yPosition + 'px');
    });

    // Reset scroll position to prevent infinite growth
    if (Math.abs(scrollPosition) > itemHeight * originalServices.length) {
      scrollPosition = 0;
      // Reposition all items
      allServices.forEach((item, index) => {
        const yPosition = scrollPosition + index * itemHeight;
        item.style.setProperty('--scroll-y', yPosition + 'px');
      });
    }
  }

  // Position items initially
  allServices.forEach((item, index) => {
    const yPosition = index * itemHeight;
    item.style.setProperty('--scroll-y', yPosition + 'px');
    item.style.position = 'absolute';
    item.style.width = '100%';
  });

  function startScroll() {
    if (scrollInterval) clearInterval(scrollInterval);
    scrollInterval = setInterval(updateScroll, 16); // ~60fps
  }

  function stopScroll() {
    if (scrollInterval) {
      clearInterval(scrollInterval);
      scrollInterval = null;
    }
  }

  // Start the infinite scroll
  startScroll();

  // Pause on hover
  servicesList.addEventListener('mouseenter', stopScroll);
  servicesList.addEventListener('mouseleave', startScroll);
}

// Apple Watch style depth effect for services
function updateServiceDepth() {
  const servicesList = document.querySelector('.services-list');
  const serviceItems = document.querySelectorAll('.service-item');

  if (!servicesList || !serviceItems.length) return;

  const containerRect = servicesList.getBoundingClientRect();
  const containerCenter = containerRect.top + containerRect.height / 2;

  serviceItems.forEach((item) => {
    if (item.matches(':hover')) return; // Skip if hovered

    const itemRect = item.getBoundingClientRect();
    const itemCenter = itemRect.top + itemRect.height / 2;

    // Only apply depth effect to items leaving at the top
    if (itemCenter < containerRect.top) {
      // Calculate how far above the container the item is
      const distanceAbove = containerRect.top - itemCenter;
      const maxFadeDistance = 100; // Distance over which to apply the effect

      // Calculate fade based on distance above container
      const fadeAmount = Math.min(distanceAbove / maxFadeDistance, 1);
      const scale = 1 - fadeAmount * 0.1; // Scale from 1 to 0.9
      const opacity = Math.max(0.7, 1 - fadeAmount * 0.3); // Opacity from 1 to 0.7

      // Apply depth effect by updating CSS custom properties
      item.style.setProperty('--depth-scale', scale);
      item.style.setProperty('--depth-opacity', opacity);
    } else {
      // Reset items that are not leaving at the top
      item.style.setProperty('--depth-scale', 1);
      item.style.setProperty('--depth-opacity', 1);
    }
  });
}

// Initialize both effects
initInfiniteScroll();
setInterval(updateServiceDepth, 50); // 20fps for smooth depth effect

// Initialize testimonials auto-scroll
initTestimonialsScroll();

function initTestimonialsScroll() {
  const track = document.querySelector('.testimonials-track');
  if (!track) return;

  const cards = Array.from(track.children);

  // Duplicate cards for seamless infinite scroll
  cards.forEach((card) => {
    const clone = card.cloneNode(true);
    track.appendChild(clone);
  });
}

// Resources slider functionality
let currentResourceIndex = 0;
const resourceTrack = document.querySelector('.resources-track');
const resourceCards = document.querySelectorAll('.resource-card');
const totalResourceCards = resourceCards.length;
const cardsPerView = 2; // Show 2 cards at a time (600px each)

function updateResourceSlider() {
  if (resourceTrack) {
    const cardWidth = 600; // card width
    const gap = 30; // gap between cards
    const translateX = -currentResourceIndex * (cardWidth + gap);
    resourceTrack.style.transform = `translateX(${translateX}px)`;
  }
}

function nextResource() {
  if (currentResourceIndex < totalResourceCards - cardsPerView) {
    currentResourceIndex++;
    updateResourceSlider();
  }
}

function previousResource() {
  if (currentResourceIndex > 0) {
    currentResourceIndex--;
    updateResourceSlider();
  }
}

// Initialize resources slider
updateResourceSlider();

// Make resource cards clickable
document.querySelectorAll('.resource-card').forEach((card) => {
  card.addEventListener('click', (e) => {
    // Don't trigger if clicking on a tag link
    if (e.target.classList.contains('resource-tag')) {
      return;
    }

    const href = card.getAttribute('data-href');
    if (href) {
      window.location.href = href;
    }
  });
});

// Sticky Navigation functionality
window.addEventListener('scroll', function () {
  const mainNav = document.querySelector('.main-nav');
  const header = document.querySelector('.header');

  if (!mainNav || !header) return;

  const headerBottom = header.offsetTop + header.offsetHeight;
  const scrollPosition = window.scrollY;

  if (scrollPosition > headerBottom) {
    mainNav.classList.add('sticky');
  } else {
    mainNav.classList.remove('sticky');
  }
});

// Smooth Button Animations with Cursor Following Shimmer
document.addEventListener('DOMContentLoaded', function () {
  const challengeButtons = document.querySelectorAll(
    '.challenge-btn, .cta-submit-btn'
  );

  challengeButtons.forEach((button) => {
    let isHovering = false;

    // Cursor following shimmer effect
    button.addEventListener('mouseenter', function () {
      isHovering = true;
    });

    button.addEventListener('mouseleave', function () {
      isHovering = false;
    });

    button.addEventListener('mousemove', function (e) {
      if (!isHovering) return;

      const rect = button.getBoundingClientRect();
      const x = ((e.clientX - rect.left) / rect.width) * 100;
      const y = ((e.clientY - rect.top) / rect.height) * 100;

      // Update the shimmer position to follow cursor
      button.style.setProperty('--shimmer-x', x + '%');
      button.style.setProperty('--shimmer-y', y + '%');
    });

    // Simple click ripple effect
    button.addEventListener('click', function (e) {
      // Don't prevent default for submit buttons
      if (button.type !== 'submit') {
        e.preventDefault();
      }

      // Create subtle ripple
      const ripple = document.createElement('span');
      const rect = button.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height) * 2;
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;

      ripple.className = 'btn-ripple';
      ripple.style.cssText = `
                position: absolute;
                left: ${x}px;
                top: ${y}px;
                width: ${size}px;
                height: ${size}px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: smoothRipple 0.6s ease-out;
                pointer-events: none;
                z-index: 10;
            `;

      button.appendChild(ripple);

      // Navigate after ripple animation starts (only for non-submit buttons)
      if (button.type !== 'submit') {
        setTimeout(() => {
          window.location.href = button.href || '#contact';
        }, 150);
      }

      // Clean up
      setTimeout(() => {
        ripple.remove();
      }, 600);
    });
  });
});

// Mobile Hamburger Menu Handler
document.addEventListener('DOMContentLoaded', function () {
  const hamburgerMenu = document.querySelector('.hamburger-menu');
  const mainNav = document.querySelector('.main-nav');
  const mobileNav = document.querySelector('.mobile-nav');
  const megaMenuItems = document.querySelectorAll('.mega-menu-item');

  if (hamburgerMenu && (mainNav || mobileNav)) {
    function isMobile() {
      return window.innerWidth <= 768;
    }

    function toggleMobileMenu() {
      // Prefer toggling the mobile-specific nav if it exists
      if (mobileNav) {
        const isOpen = mobileNav.classList.contains('open');
        hamburgerMenu.classList.toggle('active');
        mobileNav.classList.toggle('open');

        // If we're closing the menu, clean up any open drill panels
        if (isOpen) {
          // Clear all drill panels
          const drillContainer = document.querySelector('.mobile-drillpanels');
          if (drillContainer) {
            while (drillContainer.firstChild) {
              drillContainer.removeChild(drillContainer.firstChild);
            }
          }

          // Reset all accordion parents
          const accordionParents = document.querySelectorAll(
            '.mobile-accordion-parent'
          );
          accordionParents.forEach((parent) => {
            parent.classList.remove('open');
          });
        }

        // ensure desktop mainNav is closed
        if (mainNav) mainNav.classList.remove('mobile-open');
        document.body.style.overflow = !isOpen ? 'hidden' : '';
        return;
      }

      // Fallback: toggle the mainNav if mobileNav isn't present
      if (mainNav) {
        const isOpen = mainNav.classList.contains('mobile-open');
        hamburgerMenu.classList.toggle('active');
        mainNav.classList.toggle('mobile-open');
        document.body.style.overflow = !isOpen ? 'hidden' : '';
      }
    }

    hamburgerMenu.addEventListener('click', toggleMobileMenu);

    // Close mobile menu when clicking outside nav area
    document.addEventListener('click', function (e) {
      // Close mobileNav if it's open and click is outside
      if (mobileNav && mobileNav.classList.contains('open')) {
        const drillContainer = document.querySelector('.mobile-drillpanels');
        const clickedInDrill = drillContainer && drillContainer.contains(e.target);
        
        if (
          !mobileNav.contains(e.target) &&
          !hamburgerMenu.contains(e.target) &&
          !clickedInDrill
        ) {
          hamburgerMenu.classList.remove('active');
          mobileNav.classList.remove('open');
          document.body.style.overflow = '';
          
          // Clean up drill panels when closing
          if (drillContainer) {
            while (drillContainer.firstChild) {
              drillContainer.removeChild(drillContainer.firstChild);
            }
          }
        }
        return;
      }

      // Otherwise, handle closing mainNav if open
      if (mainNav && mainNav.classList.contains('mobile-open')) {
        if (!mainNav.contains(e.target) && !hamburgerMenu.contains(e.target)) {
          hamburgerMenu.classList.remove('active');
          mainNav.classList.remove('mobile-open');
          document.body.style.overflow = '';
        }
      }
    });

    // Handle mobile mega menu accordion for desktop hidden nav items (in case mainNav used)
    megaMenuItems.forEach((item) => {
      const link = item.querySelector('.nav-link');
      if (link) {
        link.addEventListener('click', function (e) {
          if (window.innerWidth <= 768) {
            // Only prevent default for mega menu triggers
            if (item.classList.contains('mega-menu-item')) {
              e.preventDefault();
              const isExpanded = item.classList.contains('mobile-expanded');
              // Close all other expanded parents
              megaMenuItems.forEach((otherItem) => {
                if (otherItem !== item) {
                  otherItem.classList.remove('mobile-expanded');
                }
              });
              // Toggle current
              if (!isExpanded) {
                item.classList.add('mobile-expanded');
              } else {
                item.classList.remove('mobile-expanded');
              }
            }
          }
        });
      }
    });

    // Hide all expanded parents when opening the mobile menu
    hamburgerMenu.addEventListener('click', function () {
      if (window.innerWidth <= 768) {
        megaMenuItems.forEach((item) => {
          item.classList.remove('mobile-expanded');
        });
      }
    });

    // Handle window resize
    window.addEventListener('resize', function () {
      if (window.innerWidth > 768) {
        hamburgerMenu.classList.remove('active');
        mainNav.classList.remove('mobile-open');
        document.body.style.overflow = '';
        megaMenuItems.forEach((item) => {
          item.classList.remove('mobile-expanded');
        });
      }
    });
  }
});

// Reliable Mega Menu Handler
document.addEventListener('DOMContentLoaded', function () {
  const megaMenuItems = document.querySelectorAll('.mega-menu-item');
  // We'll handle a single centered mega menu instance (multiple triggers can open the same centered menu)
  const GAP = 50; // px gap between main nav and mega menu

  // Only create centered mega menu for desktop
  if (window.innerWidth <= 768) return;

  // Create a dedicated centered mega menu element (separate from the ones in HTML)
  let anyMega = document.getElementById('centered-mega-menu');
  if (!anyMega) {
    anyMega = document.createElement('div');
    anyMega.id = 'centered-mega-menu';
    anyMega.className = 'mega-menu';
    document.body.appendChild(anyMega);
  }

  if (!anyMega) return;

  let hideTimer = null;
  let enterCount = 0; // counts pointer in nav or menu area
  let lastActiveItem = null; // the trigger item that last populated the centered mega

  // Positioning helper: place mega menu GAP px below the bottom of the main nav bar
  function positionMega() {
    const mainNav = document.querySelector('.main-nav');
    if (!mainNav) return;

    const navRect = mainNav.getBoundingClientRect();
    // Place menu GAP px below nav bottom (relative to viewport), unless sticky changes that
    const top = Math.ceil(navRect.bottom + GAP);
    anyMega.style.top = top + 'px';
    // center via CSS left:50% + translateX(-50%) already
  }

  // show/hide helpers
  let lastTriggerTime = 0;
  function showMega(source) {
    clearTimeout(hideTimer);
    const already = anyMega.classList.contains('show');

    // If it's already visible, just refresh
    if (already) {
      anyMega.classList.add('show');
      return;
    }

    // Allow opening only if called from a trigger, or within a short time after a trigger
    const now = Date.now();
    if (source === 'trigger') {
      lastTriggerTime = now;
      anyMega.classList.add('show');
      return;
    }

    // fallback: allow opening if a trigger occurred very recently (within 250ms)
    if (now - lastTriggerTime <= 250) {
      anyMega.classList.add('show');
      return;
    }

    // otherwise, do not open
    return;
  }

  function hideMegaSoon() {
    clearTimeout(hideTimer);
    hideTimer = setTimeout(() => {
      // only hide when pointer isn't in either nav or menu
      if (enterCount <= 0) {
        anyMega.classList.remove('show');
        // cleanup active trigger state
        if (lastActiveItem) {
          lastActiveItem.classList.remove('active-trigger');
          lastActiveItem = null;
        }
        // reset enterCount to be safe
        enterCount = 0;
      }
    }, 220);
  }

  // Attach listeners for every trigger item and the menu itself
  megaMenuItems.forEach((item) => {
    const trigger = item.querySelector('.nav-link'); // strictly the link
    if (!trigger) return; // nothing to attach

    // when pointer enters the actual nav link trigger, increment counter and show
    trigger.addEventListener('mouseenter', (e) => {
      // Debug logging (only when URL has #debug-mega)
      const debug = window.location.hash === '#debug-mega';

      // only open when entering from within/above the nav area (not when coming from below),
      // except if the pointer is coming from the mega menu itself (user moving back up)
      const mainNav = document.querySelector('.main-nav');
      const navRect = mainNav ? mainNav.getBoundingClientRect() : null;
      const TOLERANCE = 8; // px buffer

      // Determine if the pointer came from inside the centered mega menu or the hover corridor
      const fromEl = e.relatedTarget;
      let fromInsideMega = false;
      let fromHoverZone = false;
      try {
        if (fromEl && (fromEl === anyMega || anyMega.contains(fromEl))) {
          fromInsideMega = true;
        }
        if (
          fromEl &&
          hoverZone &&
          (fromEl === hoverZone || hoverZone.contains(fromEl))
        ) {
          fromHoverZone = true;
        }
      } catch (err) {
        fromInsideMega = false;
        fromHoverZone = false;
      }

      // Allow upward moves (coming back from the menu) by detecting movement direction
      const movedUpwards =
        typeof lastMouse.y === 'number' && lastMouse.y > e.clientY;

      if (debug) {
        console.log('MEGA DEBUG - Trigger mouseenter:', {
          trigger: trigger.textContent.trim(),
          clientY: e.clientY,
          navBottom: navRect ? navRect.bottom : 'no nav',
          tolerance: TOLERANCE,
          fromElement: fromEl
            ? fromEl.tagName + (fromEl.className ? '.' + fromEl.className : '')
            : 'null',
          fromInsideMega,
          fromHoverZone,
          lastMouseY: lastMouse.y,
          movedUpwards,
          willBlock:
            navRect &&
            e.clientY > navRect.bottom + TOLERANCE &&
            !fromInsideMega &&
            !fromHoverZone &&
            !movedUpwards,
        });
      }

      if (
        navRect &&
        e.clientY > navRect.bottom + TOLERANCE &&
        !fromInsideMega &&
        !fromHoverZone &&
        !movedUpwards
      ) {
        // entering the link from below (and not coming from the menu/hover corridor or moving upwards) — ignore
        if (debug) console.log('MEGA DEBUG - Blocked trigger open');
        return;
      }

      // Update active item and copy its mega content into the centered anyMega
      const itemMega = item.querySelector('.mega-menu');
      const debugMode = window.location.hash === '#debug-mega';

      if (debugMode) {
        console.log('MEGA DEBUG - Trigger mouseenter content update:', {
          trigger: trigger.textContent.trim(),
          foundItemMega: !!itemMega,
          lastActiveItem: lastActiveItem
            ?.querySelector('.nav-link')
            ?.textContent?.trim(),
          willUpdate: itemMega && anyMega !== itemMega,
        });
      }

      if (itemMega && anyMega !== itemMega) {
        // Replace centered mega content
        anyMega.innerHTML = itemMega.innerHTML;
        if (debugMode)
          console.log('MEGA DEBUG - Content updated via mouseenter');
        // Allow styles/layout to recalc before positioning
        positionMega();
        // Reposition the hover zone since menu size may have changed
        positionHoverZone();
      }

      // mark active item for styling if needed
      if (lastActiveItem && lastActiveItem !== item) {
        lastActiveItem.classList.remove('active-trigger');
      }
      item.classList.add('active-trigger');
      lastActiveItem = item;

      enterCount++;
      positionMega();
      showMega('trigger');
    });

    trigger.addEventListener('mouseleave', (e) => {
      // small delay to allow moving toward menu
      enterCount = Math.max(0, enterCount - 1);
      hideMegaSoon();
    });
  });

  // Keep menu open while hovering menu area
  anyMega.addEventListener('mouseenter', () => {
    enterCount++;
    // menu enter should keep it visible — treat as 'menu' source
    showMega('menu');
  });

  anyMega.addEventListener('mouseleave', () => {
    enterCount = Math.max(0, enterCount - 1);
    hideMegaSoon();
  });

  // Reposition on resize/scroll (throttled)
  let rafId = null;
  function schedulePosition() {
    if (rafId) return;
    rafId = requestAnimationFrame(() => {
      positionMega();
      rafId = null;
    });
  }

  window.addEventListener('resize', schedulePosition);
  window.addEventListener('scroll', schedulePosition, { passive: true });

  // initial position
  positionMega();

  // Pointer tracking: keep menu open while mouse moves from nav to menu
  let lastMouse = { x: 0, y: 0 };
  let nearTimeout = null;
  // hoverZone will be created later; declare it early so mousemove can reference it safely
  let hoverZone = null;

  function isPointInRect(x, y, rect, extra = 0) {
    return (
      x >= rect.left - extra &&
      x <= rect.right + extra &&
      y >= rect.top - extra &&
      y <= rect.bottom + extra
    );
  }

  let lastUpdateTime = 0;
  document.addEventListener('mousemove', (e) => {
    lastMouse.x = e.clientX;
    lastMouse.y = e.clientY;

    // if pointer is over nav or menu, ensure it's counted
    const mainNav = document.querySelector('.main-nav');
    const menuRect = anyMega.getBoundingClientRect();
    const navRect = mainNav ? mainNav.getBoundingClientRect() : null;

    const overMenu = isPointInRect(e.clientX, e.clientY, menuRect);
    const debug = window.location.hash === '#debug-mega';

    // Determine hovered trigger using elementFromPoint for reliability on fast moves
    let hoveredTriggerItem = null;
    try {
      const elAtPoint = document.elementFromPoint(e.clientX, e.clientY);
      if (elAtPoint) {
        const closestItem = elAtPoint.closest('.mega-menu-item');
        // Ensure the found item is actually inside the nav
        const mainNavEl = document.querySelector('.main-nav');
        if (closestItem && mainNavEl && mainNavEl.contains(closestItem)) {
          hoveredTriggerItem = closestItem;
        }
      }
    } catch (err) {
      // elementFromPoint can throw in some environments; fall back to bounding-box scan
      for (const item of megaMenuItems) {
        const link = item.querySelector('.nav-link') || item;
        if (!link) continue;
        const r = link.getBoundingClientRect();
        if (isPointInRect(e.clientX, e.clientY, r)) {
          hoveredTriggerItem = item;
          break;
        }
      }
    }
    const overTrigger = Boolean(hoveredTriggerItem);

    if (debug && overTrigger) {
      console.log('MEGA DEBUG - Mousemove over trigger:', {
        hoveredTrigger: hoveredTriggerItem
          ?.querySelector('.nav-link')
          ?.textContent?.trim(),
        menuVisible: anyMega.classList.contains('show'),
        lastActive: lastActiveItem
          ?.querySelector('.nav-link')
          ?.textContent?.trim(),
        isDifferent: hoveredTriggerItem !== lastActiveItem,
      });
    }

    if (overMenu) {
      // keep it open when pointer is over the actual menu
      enterCount = Math.max(enterCount, 1);
      showMega();
      clearTimeout(nearTimeout);
      return;
    }
    // NOTE: do NOT open the menu here when pointer is over a trigger's bounding rect;
    // opening must happen only on the real mouseenter event attached to the link element.
    // However, if the menu is already visible and the pointer moved over a different trigger,
    // update the centered menu's content so it reflects the currently hovered section.
    if (
      overTrigger &&
      hoveredTriggerItem &&
      anyMega.classList.contains('show')
    ) {
      if (hoveredTriggerItem !== lastActiveItem) {
        const itemMega = hoveredTriggerItem.querySelector('.mega-menu');
        const debugMode2 = window.location.hash === '#debug-mega';

        if (debugMode2) {
          console.log('MEGA DEBUG - Content switch attempt (mousemove):', {
            hoveredTrigger: hoveredTriggerItem
              .querySelector('.nav-link')
              ?.textContent?.trim(),
            lastActiveTrigger: lastActiveItem
              ?.querySelector('.nav-link')
              ?.textContent?.trim(),
            foundItemMega: !!itemMega,
            itemMegaHTML: itemMega
              ? itemMega.innerHTML.substring(0, 100) + '...'
              : 'none',
            menuIsVisible: anyMega.classList.contains('show'),
          });
        }

        if (itemMega) {
          anyMega.innerHTML = itemMega.innerHTML;
          if (debugMode2)
            console.log('MEGA DEBUG - Content copied via mousemove');

          // update lastActiveItem classes
          if (lastActiveItem && lastActiveItem !== hoveredTriggerItem) {
            lastActiveItem.classList.remove('active-trigger');
          }
          hoveredTriggerItem.classList.add('active-trigger');
          lastActiveItem = hoveredTriggerItem;
          // reposition in case dimensions changed
          positionMega();
          positionHoverZone();
        } else {
          if (debugMode2)
            console.log(
              'MEGA DEBUG - No .mega-menu found in hovered trigger item'
            );
        }
      } else {
        const debugMode2 = window.location.hash === '#debug-mega';
        if (debugMode2)
          console.log(
            'MEGA DEBUG - Same trigger hovered, no content switch needed'
          );
      }
    }

    // Backup: Force content update if we detect a different trigger after a small delay
    const now = Date.now();
    if (
      overTrigger &&
      hoveredTriggerItem &&
      anyMega.classList.contains('show') &&
      hoveredTriggerItem !== lastActiveItem &&
      now - lastUpdateTime > 100
    ) {
      const itemMega = hoveredTriggerItem.querySelector('.mega-menu');
      const debugMode3 = window.location.hash === '#debug-mega';

      if (debugMode3) {
        console.log('MEGA DEBUG - Forced backup content update:', {
          trigger: hoveredTriggerItem
            .querySelector('.nav-link')
            ?.textContent?.trim(),
        });
      }

      if (itemMega) {
        anyMega.innerHTML = itemMega.innerHTML;
        if (lastActiveItem) lastActiveItem.classList.remove('active-trigger');
        hoveredTriggerItem.classList.add('active-trigger');
        lastActiveItem = hoveredTriggerItem;
        positionMega();
        positionHoverZone();
        lastUpdateTime = now;
      }
    }

    // if the pointer is in the vertical corridor between nav and menu, treat as 'near' to avoid hiding
    if (navRect) {
      const top = Math.min(navRect.bottom, menuRect.top);
      const left = Math.max(navRect.left, menuRect.left);
      const right = Math.min(navRect.right, menuRect.right);

      // check if pointer is roughly between nav bottom and menu top and horizontally within menu/nav overlap
      if (
        e.clientY > navRect.bottom &&
        e.clientY < menuRect.top &&
        e.clientX >= left &&
        e.clientX <= right
      ) {
        // pointer is in the corridor between nav and menu; prevent accidental hide but do NOT open the menu
        clearTimeout(nearTimeout);
        // only keep menu open if already visible
        if (anyMega.classList.contains('show')) {
          // refresh visibility without opening
          showMega('menu');
        }
      }
    }

    // Additional safety: if the pointer is outside nav, triggers, hover zone and menu, force close
    const overNav = navRect && isPointInRect(e.clientX, e.clientY, navRect);
    const hoverZoneRect = hoverZone ? hoverZone.getBoundingClientRect() : null;
    const overHoverZone =
      hoverZoneRect && isPointInRect(e.clientX, e.clientY, hoverZoneRect);

    if (!overMenu && !overTrigger && !overNav && !overHoverZone) {
      // Pointer is outside all interactive areas -> schedule hide and reset counter
      enterCount = 0;
      hideMegaSoon();
    }
  });

  // Create an invisible hover zone element to capture pointer between nav and menu
  hoverZone = document.getElementById('mega-hover-zone');
  if (!hoverZone) {
    hoverZone = document.createElement('div');
    hoverZone.id = 'mega-hover-zone';
    document.body.appendChild(hoverZone);
  }

  function positionHoverZone() {
    const mainNav = document.querySelector('.main-nav');
    if (!mainNav) return;
    const navRect = mainNav.getBoundingClientRect();
    const menuRect = anyMega.getBoundingClientRect();
    // Prefer the horizontal overlap between nav and menu so the corridor is narrow.
    let zoneLeft = Math.max(navRect.left, menuRect.left);
    let zoneRight = Math.min(navRect.right, menuRect.right);
    let zoneWidth = zoneRight - zoneLeft;

    // If no overlap horizontally, fall back to menu's horizontal bounds
    if (zoneWidth <= 0) {
      zoneLeft = menuRect.left;
      zoneWidth = menuRect.width;
    }

    // vertical zone: from nav bottom to menu top (exclusive)
    const zoneTop = Math.max(0, Math.min(navRect.bottom, menuRect.top));
    const zoneHeight = Math.max(0, menuRect.top - navRect.bottom);

    // clamp to viewport
    const clampedLeft = Math.max(0, Math.min(window.innerWidth, zoneLeft));
    const clampedWidth = Math.max(
      0,
      Math.min(window.innerWidth - clampedLeft, zoneWidth)
    );

    hoverZone.style.left = clampedLeft + 'px';
    hoverZone.style.width = clampedWidth + 'px';
    hoverZone.style.top = zoneTop + 'px';
    hoverZone.style.height = zoneHeight + 'px';
  }

  // Hover zone should only prevent hiding; it should NOT open the menu by itself
  hoverZone.addEventListener('mouseenter', () => {
    if (anyMega.classList.contains('show')) {
      enterCount++;
    }
  });

  hoverZone.addEventListener('mouseleave', () => {
    if (anyMega.classList.contains('show')) {
      enterCount = Math.max(0, enterCount - 1);
      hideMegaSoon();
    }
  });

  // Ensure hover zone is repositioned when layout changes
  schedulePosition();
  window.addEventListener('resize', positionHoverZone);
  window.addEventListener('scroll', positionHoverZone, { passive: true });
  // call once to set initial zone
  positionHoverZone();
});

// Add smooth animation styles
const smoothStyles = document.createElement('style');
smoothStyles.textContent = `
    @keyframes smoothRipple {
        to {
            transform: scale(1);
            opacity: 0;
        }
    }
    
    .challenge-btn {
        backface-visibility: hidden;
        -webkit-font-smoothing: antialiased;
    }
`;
document.head.appendChild(smoothStyles);
