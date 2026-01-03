 <nav x-data="{
     navigationMenuOpen: false,
     navigationMenu: '',
     navigationMenuCloseDelay: 200,
     navigationMenuCloseTimeout: null,
     navigationMenuLeave() {
         let that = this;
         this.navigationMenuCloseTimeout = setTimeout(() => {
             that.navigationMenuClose();
         }, this.navigationMenuCloseDelay);
     },
     navigationMenuReposition(navElement) {
         this.navigationMenuClearCloseTimeout();
         this.$refs.navigationDropdown.style.left = navElement.offsetLeft + 'px';
         this.$refs.navigationDropdown.style.marginLeft = (navElement.offsetWidth / 2) + 'px';
     },
     navigationMenuClearCloseTimeout() {
         clearTimeout(this.navigationMenuCloseTimeout);
     },
     navigationMenuClose() {
         this.navigationMenuOpen = false;
         this.navigationMenu = '';
     },
     mobileOpen: false
 }" class="relative z-10 w-full border-b border-neutral-200 bg-white">
     <!-- HEADER (mobile) -->
     <div class="px-4 py-3 flex items-center justify-between md:hidden">
         <span class="text-lg font-bold text-neutral-800">Menu</span>

         <!-- Hamburger -->
         <button @click="mobileOpen = ! mobileOpen" class="p-2 rounded-md hover:bg-neutral-100">
             <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
             </svg>
             <svg x-show="mobileOpen" xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
             </svg>
         </button>
     </div>

     <!-- NAV LINKS -->
     <div class="md:block" :class="mobileOpen ? 'block' : 'hidden md:block'">
         <ul
             class="bg-white flex flex-col md:flex-row md:justify-center items-start md:items-center px-4 md:p-1 space-y-2 md:space-y-0 md:space-x-1 list-none text-neutral-700 border-neutral-200/80">
             <!-- DASHBOARD -->
             <li>
                 <a href="{{ route('dashboard') }}" wire:navigate
                     class="@activeClass('dashboard') inline-flex gap-2 items-center px-4 py-2 w-full md:w-max h-10 
                    text-sm font-medium rounded-md transition-colors hover:text-neutral-900 
                    focus:outline-none bg-background hover:bg-neutral-100 group">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                         stroke="currentColor" class="size-5">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                     </svg>
                     <span class="font-bold text-lg">Dashboard</span>
                 </a>
             </li>

             <!-- DATA MASTER -->
             <li>
                 <a href="{{ route('master.pl.index') }}" wire:navigate
                     class="@activeClass(['master.*']) inline-flex gap-2 items-center px-4 py-2 w-full md:w-max h-10 
                    text-sm font-medium rounded-md transition-colors hover:text-neutral-900 
                    focus:outline-none bg-background hover:bg-neutral-100 group">
                     <svg stroke="currentColor" class="size-5" viewBox="0 0 16 16" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                         <path d="M7 1H1V5H7V1Z" />
                         <path d="M7 7H1V15H7V7Z" />
                         <path d="M9 1H15V9H9V1Z" />
                         <path d="M15 11H9V15H15V11Z" />
                     </svg>
                     <span class="font-bold text-lg">Data Master</span>
                 </a>
             </li>

             <!-- DATA PEMETAAN -->
             @can('viewAny', App\Models\Kurikulum::class)
                 <li>
                     <a href="{{ route('kurikulum.index') }}" wire:navigate
                         class="@activeClass('kurikulum.index') inline-flex gap-2 items-center px-4 py-2 w-full md:w-max h-10 
                    text-sm font-medium rounded-md transition-colors hover:text-neutral-900 
                    focus:outline-none bg-background hover:bg-neutral-100 group">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                             stroke="currentColor" class="size-5">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                         </svg>
                         <span class="font-bold text-lg">Kurikulum</span>
                     </a>
                 </li>
             @endcan

             <!-- RPS KONTRAK -->
             <li>
                 <a href="{{ route('perangkat-ajar.index') }}" wire:navigate
                     class="@activeClass('perangkat-ajar.*') inline-flex gap-2 items-center px-4 py-2 w-full md:w-max h-10 
                    text-sm font-medium rounded-md transition-colors hover:text-neutral-900 
                    focus:outline-none bg-background hover:bg-neutral-100 group">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                     </svg>
                     <span class="font-bold text-lg">Perangkat Ajar</span>
                 </a>
             </li>

             <!-- USERS -->
             @can('viewAny', [App\Models\User::class])
             <li>
                 <a href="{{ route('user.index') }}" wire:navigate
                     class="@activeClass('user.index') inline-flex gap-2 items-center px-4 py-2 w-full md:w-max h-10 
                    text-sm font-medium rounded-md transition-colors hover:text-neutral-900 
                    focus:outline-none bg-background hover:bg-neutral-100 group">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-6">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                     </svg>
                     <span class="font-bold text-lg">Manage User</span>
                 </a>
             </li>
             @endcan

         </ul>
     </div>
 </nav>
