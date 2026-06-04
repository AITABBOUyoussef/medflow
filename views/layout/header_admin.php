<!-- header_admin.php -->
<header class="sticky top-0 z-10 flex h-16 w-full items-center justify-between border-b border-slate-200/60 bg-white/80 backdrop-blur-md px-4 sm:px-6 lg:px-8 shadow-sm">
    
    <!-- Left Section: Toggle Button & Title -->
    <div class="flex items-center gap-4">
        <button class="text-slate-500 hover:text-slate-700 lg:hidden p-1.5 hover:bg-slate-100 rounded-xl transition-all text-lg">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div>
            <h1 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight">Espace Configuration</h1>
            <p class="hidden sm:block text-[11px] text-slate-500 font-medium">Pilotez l'activité de la clinique et gérez le personnel.</p>
        </div>
    </div>
    
    <!-- Right Section: Actions & Profile -->
    <div class="flex items-center gap-3 sm:gap-4">
        
        <!-- System Status (Hidden on very small screens for clean look) -->
        <div class="hidden md:flex text-xs bg-emerald-50 px-3 py-1.5 border border-emerald-100 text-emerald-700 rounded-full font-semibold items-center gap-2 shadow-inner">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-[10px]">Système en ligne</span>
        </div>

        <hr class="hidden md:block h-5 w-[1px] bg-slate-200" />

        <!-- Notification Bell -->
        <div class="relative">
            <button class="relative p-2.5 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-all flex items-center justify-center">
                <i class="fa-regular fa-bell text-base sm:text-lg"></i>
                <!-- Notification Ping Badge -->
                <span class="absolute top-2 right-2 flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                </span>
            </button>
        </div>

        <!-- Vertical Divider -->
        <hr class="h-5 w-[1px] bg-slate-200" />

        <!-- User Profile Component -->
        <div class="flex items-center gap-3 pl-1 group cursor-pointer">
            <!-- Profile Info (Hidden on Mobile) -->
            <div class="hidden sm:flex flex-col text-right">
                <span class="text-xs font-bold text-slate-800 group-hover:text-cyan-600 transition-colors">Youssef Alami</span>
                <span class="text-[10px] text-slate-400 font-medium">Super Admin</span>
            </div>
            
            <!-- Profile Avatar Layout -->
            <div class="relative">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-cyan-400 to-cyan-600 text-slate-950 flex items-center justify-center font-bold text-xs shadow-md border-2 border-white ring-2 ring-slate-100 transition-transform group-hover:scale-105">
                    YA
                </div>
                <!-- Active status badge on avatar -->
                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
            </div>
        </div>

    </div>
</header>