<aside class="fixed inset-y-0 left-0 z-20 hidden w-64 bg-slate-900 border-r border-slate-800 lg:flex lg:flex-col justify-between">
    <div class="flex flex-col flex-1 p-6 overflow-y-auto">
        <div class="flex items-center gap-3 px-2 mb-8">
            <span class="text-xl bg-cyan-500/10 p-2 rounded-xl text-cyan-400 flex items-center justify-center">
                <i class="fa-solid fa-dna"></i>
            </span>
            <span class="text-lg font-bold text-white tracking-tight">Med<span class="text-cyan-400">Flow</span></span>
        </div>

        <div class="bg-slate-800/40 border border-slate-700/30 p-3 rounded-xl flex items-center gap-3 mb-6">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-cyan-400 to-cyan-600 text-slate-950 flex items-center justify-center font-bold text-xs shadow-sm">
                YA
            </div>
            <div class="min-w-0 flex-1">
                <h4 class="text-xs font-semibold text-white truncate">Youssef Alami</h4>
                <p class="text-[10px] text-cyan-400 font-medium truncate">Super Administrateur</p>
            </div>
        </div>

        <nav id="sidebar-nav" class="space-y-1 text-xs font-medium flex-1">
            <p class="text-[10px] uppercase tracking-wider text-slate-500 font-bold px-3 mb-2">Gestion Principale</p>
            
            <a href='../admin/dashboard_admin.php' class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white text-slate-400 transition-all">
                <i class="fa-solid fa-chart-pie text-sm"></i>
                <span>Vue d'ensemble (KPIs)</span>
            </a>
            
            <a href="#medecins" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white text-slate-400 transition-all">
                <i class="fa-solid fa-user-doctor text-sm"></i>
                <span>Gestion des Médecins</span>
            </a>
            
            <a href="#specialites" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white text-slate-400 transition-all">
                <i class="fa-solid fa-stethoscope text-sm"></i>
                <span>Spécialités Médicales</span>
            </a>

            <p class="text-[10px] uppercase tracking-wider text-slate-500 font-bold px-3 pt-6 mb-2">Contrôle & Cycles</p>

            <a href="../admin/table_doctors.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white text-slate-400 transition-all">
                <i class="fa-regular fa-calendar-check text-sm"></i>
                <span>Gestion des médecin</span>
            </a>

            <a href="#patients" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white text-slate-400 transition-all">
                <i class="fa-solid fa-users text-sm"></i>
                <span>Registre des Patients</span>
            </a>

            <a href="#logs" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white text-slate-400 transition-all">
                <i class="fa-solid fa-shield-halved text-sm"></i>
                <span>Sécurité & Rôles (RBAC)</span>
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-slate-800">
        <a href="/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-rose-400 hover:bg-rose-950/20 hover:text-rose-300 transition-all text-xs font-medium">
            <i class="fa-solid fa-right-from-bracket text-sm"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</aside>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll("#sidebar-nav a");
    
    function setActiveLink(activeLink) {
        navLinks.forEach(link => {
            link.classList.remove("bg-cyan-600/10", "text-cyan-400", "font-semibold");
            link.classList.add("text-slate-400", "hover:bg-slate-800/60", "hover:text-white");
        });    
        activeLink.classList.add("bg-cyan-600/10", "text-cyan-400", "font-semibold");
        activeLink.classList.remove("text-slate-400", "hover:bg-slate-800/60", "hover:text-white");
    }

    const currentPath = window.location.pathname; 
    const currentHash = window.location.hash;     

    let matched = false;

    navLinks.forEach(link => {
        const href = link.getAttribute("href");

        if (!href.startsWith("#")) {
            const linkFile = href.substring(href.lastIndexOf('/') + 1);
            const currentFile = currentPath.substring(currentPath.lastIndexOf('/') + 1);

            if (linkFile === currentFile && currentFile !== "") {
                setActiveLink(link);
                matched = true;
            }
        } 
        else if (currentHash && href === currentHash) {
            setActiveLink(link);
            matched = true;
        }      

        link.addEventListener("click", function () {
            setActiveLink(this);
        });
    });

    if (!matched && navLinks.length > 0 && (currentPath.endsWith('dashboard_admin.php') || currentPath.endsWith('/'))) {
        setActiveLink(navLinks[0]);
    }
});
</script>