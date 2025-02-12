<template>
	<div class="r-flex r-justify-between r-mb-6">
		<div ref="riveWrapper" class="r-relative" style="width: 25%;">
			<canvas ref="riveCanvas" :height="height" :width="width" class="r-w-full"></canvas>
			<button @click="expandCanvas" class="r-absolute r-bottom-0 r-right-0 r-w-5 r-h-5">
				<svg v-if="!isExpanded" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path class="r-fill-gray-500 " fill-rule="evenodd" clip-rule="evenodd" d="M28.1262 3.12492C28.1262 1.39907 29.5253 0 31.2512 0H46.8758C48.6016 0 50.0007 1.39907 50.0007 3.12492V18.7495C50.0007 20.4754 48.6016 21.8744 46.8758 21.8744C45.1499 21.8744 43.7508 20.4754 43.7508 18.7495V6.24984H31.2512C29.5253 6.24984 28.1262 4.85077 28.1262 3.12492ZM3.12687 28.1243C4.85272 28.1243 6.25179 29.5234 6.25179 31.2492V43.7489H18.7515C20.4773 43.7489 21.8764 45.148 21.8764 46.8738C21.8764 48.5996 20.4773 49.9987 18.7515 49.9987H3.12687C1.40103 49.9987 0.00195312 48.5996 0.00195312 46.8738V31.2492C0.00195312 29.5234 1.40103 28.1243 3.12687 28.1243Z" fill="white"/>
				</svg>
				<svg v-if="isExpanded" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path class="r-fill-gray-500 " fill-rule="evenodd" clip-rule="evenodd" d="M0 30.9743C0 29.2451 1.40174 27.8434 3.13087 27.8434H18.7852C20.5144 27.8434 21.9161 29.2451 21.9161 30.9743V46.6286C21.9161 48.3577 20.5144 49.7595 18.7852 49.7595C17.0561 49.7595 15.6544 48.3577 15.6544 46.6286V34.1051H3.13087C1.40174 34.1051 0 32.7034 0 30.9743Z" fill="white"/>
					<path class="r-fill-gray-500 " fill-rule="evenodd" clip-rule="evenodd" d="M31.4562 0C33.1631 0 34.5468 1.38372 34.5468 3.09063V15.4532H46.9094C48.6163 15.4532 50 16.8369 50 18.5438C50 20.2507 48.6163 21.6344 46.9094 21.6344H31.4562C29.7493 21.6344 28.3656 20.2507 28.3656 18.5438V3.09063C28.3656 1.38372 29.7493 0 31.4562 0Z" fill="white"/>
				</svg>
			</button>
		</div>

		<div class="r-text-xs r-text-right">
			<p><strong>Width:</strong> {{ sourceWidth }} px</p>
			<p><strong>Height:</strong> {{ sourceHeight }} px</p>
			<p><strong>Artboards:</strong> {{ artboards.join(', ') || 'None' }}</p>
			<p><strong>Animations:</strong> {{ animations.join(', ') || 'None' }}</p>
			<p><strong>State Machines:</strong> {{ stateMachines.join(', ') || 'None' }}</p>
		</div>
	</div>
</template>

<script>
	import { Rive } from '@rive-app/canvas';

	export default {
		props: [
			'src',
			'stateMachine',
			'artboard',
			'animation',
			'shouldDisableRiveListeners',
			'isTouchScrollEnabled',
			'width',
			'height',
		],
		data() {
			return {
				isExpanded: false,
				showInfo: false,
				sourceWidth: null,
				sourceHeight: null,
				artboards: [],
				animations: [],
				stateMachines: [],
				contents: null,
			};
		},
		mounted() {
			this.rive = new Rive({
				src: this.src,
				stateMachines: this.stateMachine,
				canvas: this.$refs.riveCanvas,
				autoplay: true,
				artboard: this.artboard,
				animations: this.animation,
				shouldDisableRiveListeners: this.shouldDisableRiveListeners,
				isTouchScrollEnabled: this.isTouchScrollEnabled,
				onLoad: () => {
					// Log the contents of the Rive file
					this.sourceWidth = this.rive.bounds.maxX;
					this.sourceHeight = this.rive.bounds.maxY;
					this.artboards = this.rive.contents.artboards.map(artboard => artboard.name);
					this.animations = this.rive.contents.artboards.map(artboard => artboard.animations);
					this.stateMachines = this.rive.contents.artboards.map(artboard => artboard.stateMachines.map(stateMachine => stateMachine.name));
				},
			});

			this.rive.resizeDrawingSurfaceToCanvas();
		},
		methods: {
			expandCanvas() {
				this.isExpanded = !this.isExpanded;
				if (this.isExpanded) {
					this.$refs.riveWrapper.style.width = '100%';
				} else {
					this.$refs.riveWrapper.style.width = '25%';
				}
				this.rive.resizeDrawingSurfaceToCanvas();
			}
		}
	};
</script>
