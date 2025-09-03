<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts config to match project -->
    <script>
        tailwind.config = {
          theme: {
            extend: {
              fontFamily: {
                rustler: ['RustlerBarter', 'sans-serif'],
                bricolage: ['"Bricolage Grotesque"', 'sans-serif'],
              }
            }
          }
        }
    </script>

    <!-- Load RustlerBarter font from public/fonts -->
    <style>
      @font-face {
        font-family: 'RustlerBarter';
        src: url('/fonts/RustlerBarter.otf') format('opentype');
        font-weight: normal;
        font-style: normal;
      }

      /* Custom scrollbar styles (from My Orders) */
      .custom-scrollbar::-webkit-scrollbar {
        width: 14px;
      }
      .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
      }
      .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #E7E4E1;
        border-radius: 10px;
        border: 4px solid transparent;
        background-clip: content-box;
      }
    </style>

    <!-- Load Bricolage Grotesque from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title>Account Center - JOAZ</title>
</head>
<body class="bg-[#FCFCFC] text-[#212121]">
  <div class="min-h-screen flex flex-col">
    @include('components.header')
    @include('components.cart-notification')

    <!-- Tabs Header -->
    <div class="flex font-bricolage font-semibold px-16 py-12 text-[#212121]/60 flex-row text-xl gap-10">
      <h1 class="cursor-pointer" data-tab="account">ACCOUNT</h1>
      <h1 class="cursor-pointer" data-tab="address">ADDRESS BOOK</h1>
      <h1 class="cursor-pointer" data-tab="cart">MY CART</h1>
      <h1 class="cursor-pointer" data-tab="orders">MY ORDERS</h1>
    </div>

    <!-- Sections -->
    <main>
      <section id="section-account">@include('components.account-section')</section>
      <section id="section-address" class="hidden">@include('components.address-book-section')</section>
      <section id="section-cart" class="hidden">@include('components.cart-section', ['cart' => $cart])</section>
      <section id="section-orders" class="hidden">@include('components.orders-section')</section>
    </main>

    @include('components.footer')
  </div>

  <script>
    (function() {
      const ACTIVE_CLASSES = ['text-transparent', 'bg-clip-text', 'bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]'];
      const tabs = document.querySelectorAll('[data-tab]');
      const sections = {
        account: document.getElementById('section-account'),
        address: document.getElementById('section-address'),
        cart: document.getElementById('section-cart'),
        orders: document.getElementById('section-orders'),
      };

      function setActiveTab(tabName) {
        const valid = ['account', 'address', 'cart', 'orders'];
        const name = valid.includes(tabName) ? tabName : 'account';

        // Show/hide sections
        Object.entries(sections).forEach(([k, el]) => {
          if (!el) return;
          if (k === name) el.classList.remove('hidden');
          else el.classList.add('hidden');
        });

        // Toggle tab styles
        tabs.forEach(t => {
          const isActive = t.dataset.tab === name;
          // Remove possible active classes first
          ACTIVE_CLASSES.forEach(c => t.classList.remove(c));
          // Reset base color
          t.classList.remove('text-[#212121]');
          t.classList.remove('text-[#212121]/60');
          t.classList.add('text-[#212121]/60');

          if (isActive) {
            // Active gradient style
            t.classList.remove('text-[#212121]/60');
            ACTIVE_CLASSES.forEach(c => t.classList.add(c));
          }
        });

        // Update location hash (no scroll jump)
        if (history.replaceState) {
          history.replaceState(null, '', '#' + name);
        } else {
          location.hash = name;
        }
      }

      // Click handlers
      tabs.forEach(t => t.addEventListener('click', () => setActiveTab(t.dataset.tab)));

      // Initialize from hash or default to account
      const initial = (location.hash || '').replace('#', '') || 'account';
      setActiveTab(initial);
    })();
  </script>
</body>
</html>
