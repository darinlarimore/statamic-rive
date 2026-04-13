<template>
	<div class="dark:r-bg-gray-600/5 r-rounded r-p-4 r-mb-4 r-border r-border-black/30">
		<div v-if="!data.url">
			<p class="r-text-sm r-mb-2">Upload a .riv file</p>
			<assets-fieldtype
			class="assets-fieldtype"
			:value="riveId"
			ref="assets"
			handle="assets"
			:config="assetsConfig"
			:meta="assetsMeta"
			:readOnly="readOnly"
			@update:value="updateRive"
			></assets-fieldtype>
		</div>

		<!-- else display a clear button  -->
		<div v-else>
			<div class="r-flex r-justify-between r-items-center r-p-4">
				<p class="r-text-sm">Selected Rive Animation:</p>
				<div class="r-flex r-items-center r-gap-2">
					<p class="r-text-sm">{{data.fileName}}</p>
					<button @click="riveClear" class=""> ×
					</button>
				</div>
			</div>
		</div>
		<div v-if="data.error" class="r-text-red-500">{{ data.error }}</div>


		<div v-if="data.url" class="r-p-4">
			<RiveWrapper
				:key="JSON.stringify(data)"
				:src="data.url"
				:stateMachine="data.stateMachine"
				:artboard="data.artboard"
				:animation="data.animation"
				:shouldDisableRiveListeners="data.shouldDisableRiveListeners"
				:isTouchScrollEnabled="data.isTouchScrollEnabled"
				:width="data.width"
				:height="data.height"
			/>

			<button @click="showOptions = !showOptions" class="r-flex d-my-4 r-items-center text-sm">Configuration Options
				<svg :class="showOptions ? 'r-rotate-180' : '' " xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 20 20"><path fill="currentColor" d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path></svg>
			</button>

			<div v-if="showOptions" class="r-grid r-mt-6 r-gap-4">

				<div>
					<label class="r-text-sm font-medium">Width</label>
					<p class="r-text-xs r-text-gray-500">Width of the animation</p>
					<input type="text" class="w-full block bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-base rounded-lg px-3 py-2 h-10 r-mt-1" v-model="data.width" />
				</div>

				<div>
					<label class="r-text-sm font-medium">Height</label>
					<p class="r-text-xs r-text-gray-500">Height of the animation</p>
					<input type="text" class="w-full block bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-base rounded-lg px-3 py-2 h-10 r-mt-1" v-model="data.height" />
				</div>

				<div>
					<label class="r-text-sm font-medium">Animation</label>
					<p class="r-text-xs r-text-gray-500">Name of the animation to use</p>
					<input type="text" class="w-full block bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-base rounded-lg px-3 py-2 h-10 r-mt-1" v-model="data.animation" />
				</div>

				<div>
					<label class="r-text-sm font-medium">Art Board</label>
					<p class="r-text-xs r-text-gray-500">Name of the artboard to use</p>
					<input type="text" class="w-full block bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-base rounded-lg px-3 py-2 h-10 r-mt-1" v-model="data.artboard" />
				</div>

				<div>
					<label class="r-text-sm font-medium">State Machine</label>
					<p class="r-text-xs r-text-gray-500">Name of the state machine to use</p>
					<input type="text" class="w-full block bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-base rounded-lg px-3 py-2 h-10 r-mt-1" v-model="data.stateMachine" />
				</div>

				<div class="r-flex r-items-center r-gap-2">
					<input type="checkbox" v-model="data.shouldDisableRiveListeners" class="rounded border-gray-300" />
					<div>
						<label class="r-text-sm font-medium">Disable Rive Listeners</label>
						<p class="r-text-xs r-text-gray-500">Prevent any event listeners from being set up on the element</p>
					</div>
				</div>

				<div class="r-flex r-items-center r-gap-2">
					<input type="checkbox" v-model="data.isTouchScrollEnabled" class="rounded border-gray-300" />
					<div>
						<label class="r-text-sm font-medium">Touch Scroll Enabled</label>
						<p class="r-text-xs r-text-gray-500">Allows scrolling behavior to still occur on canvas elements when a touch/drag action is performed on touch-enabled devices.</p>
					</div>
				</div>

			</div>
		</div>
	</div>
</template>

<script>
	import RiveWrapper from './RiveWrapper.vue';
	export default {
		components: { RiveWrapper },
		mixins: [Fieldtype],
		data() {
			return {
				showOptions: false,
				data: {
					isTouchScrollEnabled: this.value?.isTouchScrollEnabled || true,
					shouldDisableRiveListeners: this.value?.shouldDisableRiveListeners || false,
					animation: this.value?.animation || null,
					artboard: this.value?.artboard || null,
					stateMachine: this.value?.stateMachine || null,
					width: this.value?.width || 500,
					height: this.value?.height || 500,
					url: this.value?.url || null,
					id: this.value?.id || null,
					fileName: this.value?.fileName || null,
					alt: this.value?.alt || null,
					error: this.value?.error || null,
				}
			};
		},

		watch: {
			data: {
				deep: true,
				handler() {
					this.update(this.data);
				}
			}
		},

		computed: {
			riveId() {
				return this.data.id ? [this.data.id] : [];
			},

			assetsConfig() {
				return {
					container: this.meta.container?.handle || this.config.container,
					folder: this.config.folder,
					restrict: this.config.restrict,
					allow_uploads: this.config.allow_uploads,
					max_files: 1,
					min_files: 0,
					mode: 'list',
				}
			},

			assetsMeta() {
				return {
					container: this.meta.container,
					data: null,
					dynamicFolder: null,
					rename_folder: null,
				}
			},
		},
		methods: {
			updateRive(assets) {
				if (assets[0]) {
					this.getAsset(assets[0], 'rive', ['riv']);
				}
			},

			riveClear() {
				this.data.url = null;
				this.data.id = null;
				this.data.fileName = null;
				this.data.alt = null;
			},

			getAsset(value, handle, fileTypes) {
				this.$axios
					.post(this.cpUrl("assets-fieldtype"), {
							assets:[ value ],
					})
					.then((response) => {
						if (fileTypes.includes(response.data[0].extension)) {
							this.data.url = response.data[0].url;
							this.data.id = response.data[0].id;
							this.data.fileName = response.data[0].basename;
							this.data.alt = response.data[0].values.alt;
							this.data.error = null;
						} else {
							this.data.error = "Invalid file type. Please upload a .riv file";
						}
					})
			},

			cpUrl(url) {
				url = Statamic.$config.get("cpUrl") + "/" + url;
				return url.replace(/([^:])(\/\/+)/g, "$1/");
			},
		}
	};
</script>
