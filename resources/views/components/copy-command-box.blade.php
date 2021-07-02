@props(['command', 'title'])

<div
    x-data="copyCommandBox({ command: `{{ str_replace("\\", "\\\\", $command) }}` })"
    class="prose-sm text-left"
>
    <h4>{{ $title }}</h4>
    <div class="overflow-hidden relative bg-gray-800 px-4 py-0.5 rounded text-gray-100">
        <pre>{{ $command }}</pre>

        <div class="absolute bottom-0 right-0 flex items-center justify-end space-x-3">
            <div
                x-show="success"
                class="text-white font-semibold text-sm"
            >
                copied!
            </div>
            <button
                class="text-gray-900 font-semibold bg-lime-400 px-3 py-0.5 text-sm rounded-tl-md"
                @click.stop.prevent="copyCommand"
                data-qa="button-copy-cmd"
            >
                {{ __('Copy') }}
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
  window.copyCommandBox = function({ command }) {
    return {
      command,
      success: false,
      copyCommand() {
        this.$clipboard(this.command);
        this.success = true;
        setTimeout(() => {
          this.success = false;
        }, 5000);
      },
    }
  }
</script>

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-clipboard@1.x.x/dist/alpine-clipboard.js"></script>
    @endpush
@endonce
