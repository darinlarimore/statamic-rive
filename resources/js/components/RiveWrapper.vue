<template>
	<canvas ref="riveCanvas" :height="height" :width="width" class="r-w-full r-max-h-96"></canvas>
</template>

<script>
	import {Rive} from '@rive-app/canvas';

	export default {
		props: [
			'src',
			'stateMachine',
			'artboard',
			'animation',
			'shouldDisableRiveListeners',
			'width',
			'height',
		],
		mounted() {
			const rive = new Rive({
				src: this.src,
				stateMachines: this.stateMachine,
				canvas: this.$refs.riveCanvas,
				autoplay: true,
				artboard: this.artboard,
				animations: this.animation,
				shouldDisableRiveListeners: this.shouldDisableRiveListeners,
			});
			rive.resizeDrawingSurfaceToCanvas();
		}
	};
</script>
