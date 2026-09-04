@extends('layouts.app')

@section('title', $campaign->title . ' - Campaign Donasi SQR')
@section('meta_description', $campaign->excerpt ?? 'Program donasi dan ta\'awun Saung Quran Rabbani')

@section('content')

@include('partials.navbar')
@include('partials.mobile-sidebar')

<!-- Header Campaign -->
<section class="pt-28 pb-10 bg-gradient-to-b from-sqr-dark to-sqr-green text-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="bg-sqr-orange/20 text-sqr-orange border border-sqr-orange/40 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider inline-block mb-3">
            <i class="fa-solid fa-hand-holding-heart mr-1.5"></i> {{ $campaign->category }}
        </span>
        <h1 class="font-title text-2xl sm:text-4xl font-black text-white tracking-tight leading-snug">{{ $campaign->title }}</h1>
        <p class="mt-2 text-xs sm:text-sm text-gray-200 opacity-90 max-w-xl mx-auto">{{ $campaign->excerpt }}</p>
    </div>
</section>

<!-- Content & Donasi Card -->
<section class="py-12 bg-[#f0f8d3]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Image & Description Story -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-sqr-green/10">
                <img src="{{ $campaign->image_url }}" alt="{{ $campaign->title }}" class="w-full h-72 sm:h-96 object-cover">
                <div class="p-6 sm:p-8 space-y-4">
                    <h2 class="font-title font-bold text-xl text-sqr-green">Tentang Program Ini</h2>
                    <div class="prose max-w-none text-xs sm:text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $campaign->description }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Donation Progress & Bank Transfer Card -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Progress Card -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xl border border-sqr-green/10 space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider">Terkumpul</span>
                        <span class="font-title font-black text-2xl sm:text-3xl text-sqr-green">{{ $campaign->formatted_current }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[11px] font-bold text-gray-500 block uppercase tracking-wider">Target</span>
                        <span class="font-title font-bold text-sm text-gray-700">{{ $campaign->formatted_target }}</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div>
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden shadow-inner border border-gray-200">
                        <div class="bg-gradient-to-r from-sqr-orange to-amber-500 h-full rounded-full transition-all duration-1000 shadow-md" style="width: {{ $campaign->percentage_progress }}%;"></div>
                    </div>
                    <div class="flex justify-between items-center text-xs font-bold text-sqr-green mt-2">
                        <span><i class="fa-solid fa-chart-line text-sqr-orange mr-1"></i> {{ $campaign->percentage_progress }}% Terpenuhi</span>
                        <span class="text-gray-500 font-normal">Sisa waktu 30 hari lagi</span>
                    </div>
                </div>

                <!-- Bank Info Transfer Box -->
                <div class="bg-sqr-bg/80 p-5 rounded-2xl border border-sqr-green/20 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-sqr-green uppercase tracking-wider"><i class="fa-solid fa-building-columns mr-1.5 text-sqr-orange"></i> {{ $campaign->bank_name }}</span>
                        <button onclick="copyBankNumber('{{ $campaign->bank_account }}')" class="text-[10px] bg-sqr-green text-white font-bold px-2.5 py-1 rounded-lg hover:bg-sqr-dark transition">
                            <i class="fa-solid fa-copy"></i> Salin
                        </button>
                    </div>
                    <div>
                        <p class="font-title font-black text-lg text-sqr-green tracking-wider" id="bankNo">{{ $campaign->bank_account }}</p>
                        <p class="text-[11px] font-semibold text-gray-600">a.n. {{ $campaign->bank_holder }}</p>
                    </div>
                </div>

                <!-- CTA Action Button -->
                <a href="https://wa.me/6281293721163?text=Halo%20Admin%20SQR%2C%20saya%20ingin%20berdonasi%20untuk%20program%20*{{ urlencode($campaign->title) }}*" 
                   target="_blank"
                   class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-title font-bold text-sm py-4 rounded-2xl shadow-xl transition flex items-center justify-center gap-2.5 transform hover:-translate-y-1">
                    <i class="fa-brands fa-whatsapp text-xl"></i> Konfirmasi Donasi via WhatsApp
                </a>
            </div>

            <!-- Program Terkait -->
            @if($related->count() > 0)
            <div class="bg-white p-6 rounded-3xl shadow-lg border border-sqr-green/10 space-y-4">
                <h3 class="font-title font-bold text-base text-sqr-green">Program Donasi Lainnya</h3>
                <div class="space-y-3">
                    @foreach($related as $rel)
                    <a href="{{ route('berbagi.detail', $rel->slug) }}" class="flex gap-3 p-3 rounded-2xl bg-sqr-bg/50 hover:bg-sqr-bg transition border border-sqr-green/10 group">
                        <img src="{{ $rel->image_url }}" class="w-16 h-16 object-cover rounded-xl shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-title font-bold text-xs text-sqr-green group-hover:text-sqr-orange transition line-clamp-1">{{ $rel->title }}</h4>
                            <p class="text-[10px] text-gray-500 mt-1 font-semibold">{{ $rel->formatted_current }} / {{ $rel->formatted_target }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<script>
    function copyBankNumber(text) {
        navigator.clipboard.writeText(text);
        alert('Nomor Rekening ' + text + ' berhasil disalin!');
    }
</script>

@endsection
