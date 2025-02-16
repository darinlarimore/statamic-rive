<template>
	<div class="r-flex r-justify-between r-mb-6 r-gap-4">
		<div ref="riveWrapper">
			<canvas ref="riveCanvas" :height="height" :width="width" class="r-w-full r-max-h-96"></canvas>
		</div>

		<div class="r-text-xs r-text-right">
			<p><strong>Width:</strong> <br>{{ sourceWidth }} px</p>
			<p><strong>Height:</strong> <br>{{ sourceHeight }} px</p>
			<p><strong>Artboards:</strong></p>
			<ul v-if="artboards.length">
				<li v-for="(artboard, i) in showAllArtboards ? artboards : artboards.slice(0, 10)" :key="i">
					{{ artboard }}
				</li>
				<li v-if="artboards.length > 10 && !showAllArtboards">
					<button @click="showAllArtboards = true">...</button>
				</li>
			</ul>
			<p v-else>None</p>

			<p><strong>Animations:</strong></p>
			<ul v-if="animations.length && animations[0]?.length">
				<li v-for="(animation, i) in showAllAnimations ? animations[0] : animations[0].slice(0, 10)" :key="i">
					{{ animation }}
				</li>
				<li v-if="animations[0].length > 10 && !showAllAnimations">
					<button @click="showAllAnimations = true">...</button>
				</li>
			</ul>
			<p v-else>None</p>

			<p><strong>State Machines:</strong></p>
			<ul v-if="stateMachines.length && stateMachines[0]?.length">
				<li v-for="(machine, i) in showAllStateMachines ? stateMachines[0] : stateMachines[0].slice(0, 10)" :key="i">
					{{ machine }}
				</li>
				<li v-if="stateMachines[0].length > 10 && !showAllStateMachines">
					<button @click="showAllStateMachines = true">...</button>
				</li>
			</ul>
			<p v-else>None</p>
		</div>
	</div>
</template>

<script>
	import { Rive } from "@rive-app/webgl";

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
				sourceWidth: null,
				sourceHeight: null,
				artboards: [],
				animations: [],
				stateMachines: [],
				contents: null,
				showAllArtboards: false,
				showAllAnimations: false,
				showAllStateMachines: false,
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
		}
	};
</script>
