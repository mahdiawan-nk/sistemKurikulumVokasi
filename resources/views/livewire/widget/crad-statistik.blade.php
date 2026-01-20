<div>
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-2 gap-4">
        <x-ui.widgets.card-statistik :title="$statsKurikulum['title']" :value="$statsKurikulum['value']" :data="$statsKurikulum['details']" :show="$statsKurikulum['show']" />
        <x-ui.widgets.card-statistik :title="$statsPerangkatAjar['title']" :value="$statsPerangkatAjar['value']" :data="$statsPerangkatAjar['details']" :show="$statsPerangkatAjar['show']" />
    </div>
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 xl:grid-cols-3 gap-4">
        <x-ui.widgets.card-statistik :title="$statsDosen['title']" :value="$statsDosen['value']" :show="$statsDosen['show']" />
        <x-ui.widgets.card-statistik :title="$statsProgramStudi['title']" :value="$statsProgramStudi['value']" :show="$statsProgramStudi['show']" />
        <x-ui.widgets.card-statistik :title="$statsMatakuliah['title']" :value="$statsProgramStudi['value']" :show="$statsMatakuliah['show']" />

    </div>

</div>
