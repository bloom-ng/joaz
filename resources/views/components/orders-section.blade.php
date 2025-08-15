<!-- Orders Section (inner content only) -->
<div>
  <div class="flex flex-row font-rustler text-4xl items-center justify-center pt-8 pb-4">MY ORDERS</div>

  <div class="flex flex-col items-stretch gap-8 px-16 rounded-2xl">
    <div class="flex font-bricolage font-semibold text-[#212121]/60 flex-row gap-10">
      <div class="relative">
        <h1 class="text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">All orders</h1>
        <div class="absolute bottom-0 left-0 w-full h-[1.5px] bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]"></div>
      </div>
      <h1>Completed</h1>
      <h1>Pending</h1>
      <h1>Returned</h1>
    </div>
    <div class="border border-[1px] border-[#21212199]/30 font-bricolage w-full rounded-2xl overflow-hidden">
      <div class="overflow-y-auto max-h-[574px] custom-scrollbar">
        <table class="table-auto w-full">
          <thead class="sticky top-0 bg-[#FCFCFC] z-10 w-full border-b-[1px] border-[#212121]/20">
            <tr>
              <th class="text-left px-6 py-4">#</th>
              <th class="text-left px-6 py-4">Product Name</th>
              <th class="text-left px-6 py-4">Quantity</th>
              <th class="text-left px-6 py-4">Total</th>
              <th class="text-left px-6 py-4">Status</th>
            </tr>
          </thead>
          <tbody class="bg-[#FFFFFF]">
            <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
              <td class="px-6 py-4 align-middle">1</td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-row gap-3 items-center">
                  <img class="w-[120px] h-[132px] object-cover rounded-xl" src="{{ asset('images/product1.png') }}" alt="">
                  <div class="flex flex-col gap-1">
                    <h1 class="font-semibold">French curls braid</h1>
                    <p>12” (12 Inches) <br> Metallic Grey, 037</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-row items-start justify-start">
                  <p>4</p>
                </div>
              </td>
              <td class="px-6 py-4 align-middle whitespace-nowrap">
                <span class="flex flex-row gap-1 items-center">
                  <img class="w-4 h-4" src="/images/naira.png" alt="">
                  <p>58,000.00</p>
                </span>
              </td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-col w-28 items-center">
                  <p class="w-full bg-[#85BB3F33] text-sm text-center rounded-3xl px-5 py-2 text-[#85BB3F]">Completed</p>
                </div>
              </td>
            </tr>
            <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
              <td class="px-6 py-4 align-middle">2</td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-row gap-3 items-center">
                  <img class="w-[120px] h-[132px] object-cover rounded-xl" src="{{ asset('images/product1.png') }}" alt="">
                  <div class="flex flex-col gap-1">
                    <h1 class="font-semibold">French curls braid</h1>
                    <p>12” (12 Inches) <br> Metallic Grey, 037</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-row items-start justify-start">
                  <p>4</p>
                </div>
              </td>
              <td class="px-6 py-4 align-middle whitespace-nowrap">
                <span class="flex flex-row gap-1 items-center">
                  <img class="w-4 h-4" src="/images/naira.png" alt="">
                  <p>58,000.00</p>
                </span>
              </td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-col w-28 items-center">
                  <p class="w-full bg-[#BB943F33] text-sm text-center rounded-3xl px-5 py-2 text-[#BB943F]">Pending</p>
                </div>
              </td>
            </tr>
            <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
              <td class="px-6 py-4 align-middle">3</td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-row gap-3 items-center">
                  <img class="w-[120px] h-[132px] object-cover rounded-xl" src="{{ asset('images/product1.png') }}" alt="">
                  <div class="flex flex-col gap-1">
                    <h1 class="font-semibold">French curls braid</h1>
                    <p>12” (12 Inches) <br> Metallic Grey, 037</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-row items-start justify-start">
                  <p>4</p>
                </div>
              </td>
              <td class="px-6 py-4 align-middle whitespace-nowrap">
                <span class="flex flex-row gap-1 items-center">
                  <img class="w-4 h-4" src="/images/naira.png" alt="">
                  <p>58,000.00</p>
                </span>
              </td>
              <td class="px-6 py-4 align-middle">
                <div class="flex flex-col w-28 items-center">
                  <p class="w-full bg-[#BB3F3F33] text-sm text-center rounded-3xl px-5 py-2 text-[#BB3F3F]">Returned</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
