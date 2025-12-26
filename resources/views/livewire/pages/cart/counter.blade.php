<div>

   <a href="{{ route('cart.show') }}"
      class="relative inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-black text-white hover:bg-gray-900">

   
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
         <path stroke-linecap="round" stroke-linejoin="round"
               d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13 5.4 5M7 13l-2 9m14-9 2 9M9 22a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/>
      </svg>

      <span class="font-medium">Cart</span>

      <span class="absolute -top-2 -right-2 min-w-[22px] h-[22px] px-1
                  inline-flex items-center justify-center rounded-full text-xs font-semibold
                  bg-white text-gray-900 border border-gray-200">
         {{ $this->count }}
      </span>
   </a>

</div>
