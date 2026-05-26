<a href="{{ $link }}" class="block">
    <div class="
        relative bg-white rounded-2xl p-6 shadow-sm
        hover:shadow-lg hover:scale-[1.02] transition cursor-pointer
        {{ $destaque ? 'border-2 border-orange-500' : 'border' }}
    ">

        @if($badge)
            <div class="absolute top-3 right-3 bg-orange-500 text-white text-xs px-3 py-1 rounded-full">
                {{ $badge }}
            </div>
        @endif

        <h3 class="text-xl font-bold text-gray-800">
            {{ $titulo }}
        </h3>

        <p class="text-gray-500 mt-2">
            {{ $descricao }}
        </p>

        <div class="mt-4 text-2xl font-bold text-gray-900">
            {{ $preco }}
        </div>

    </div>
</a>