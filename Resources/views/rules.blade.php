<section class="rules-wrapper">
    <div class="rules-title">Rules</div>

    @foreach ($rules as $item)
        <div class="rules-wrapper-container">
            <h3 class="question">
                {{ $item->question }}
                <i class="ph ph-plus"></i>
            </h3>
            <div class="answercont">
                <div class="answer">
                    {!! $service->parseBlocks($item) !!}
                </div>
            </div>
        </div>
    @endforeach
</section>
