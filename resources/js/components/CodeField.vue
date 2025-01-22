<template>
	<portal name="code-fullscreen" :disabled="!fullScreenMode" target-class="code-fieldtype">
		<div class="code-fieldtype-container" :class="['dark', {'code-fullscreen': fullScreenMode }]">
			<div class="code-fieldtype-toolbar">
				<button
					@click="fullScreenMode = !fullScreenMode"
					class="r-p-1 r-text-gray-500 hover:r-text-gray-700"
					:title="fullScreenMode ? 'Exit Full Screen' : 'Full Screen'"
				>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" class="h-3 w-3"><path fill="currentColor" fill-rule="evenodd" d="M1.073 4.658.575 4.7c.054.64.828.91 1.274.465l.95-.95 1.489 1.489A1 1 0 0 0 5.702 4.29L4.212 2.8l.95-.95A.746.746 0 0 0 4.698.577C3.358.464 2.472.481 1.07.627a.5.5 0 0 0-.445.445C.479 2.474.462 3.361.575 4.7l.498-.042Zm12.352.042c-.054.64-.828.91-1.274.465l-.95-.95-1.489 1.489A1 1 0 1 1 8.298 4.29L9.787 2.8l-.95-.95c-.445-.445-.176-1.219.464-1.273 1.34-.113 2.227-.096 3.629.05a.5.5 0 0 1 .445.445c.146 1.402.163 2.289.05 3.628Zm0 4.6c-.054-.64-.828-.91-1.274-.465l-.95.95-1.489-1.489A1 1 0 1 0 8.298 9.71l1.489 1.49-.95.95c-.445.445-.176 1.219.464 1.273 1.34.113 2.227.096 3.629-.05a.5.5 0 0 0 .445-.445c.146-1.402.163-2.289.05-3.628Zm-12.8 3.628C.479 11.526.462 10.639.575 9.3c.054-.64.828-.91 1.274-.465l.95.95 1.489-1.489A1 1 0 1 1 5.702 9.71l-1.49 1.49.95.95a.746.746 0 0 1-.464 1.273c-1.34.113-2.226.096-3.628-.05a.5.5 0 0 1-.445-.445Z" clip-rule="evenodd"></path></svg>
				</button>
			</div>
			<textarea ref="textarea" class="r-w-full r-bg-gray-700"></textarea>
		</div>
	</portal>
</template>

<script>
import CodeMirror from 'codemirror';
import 'codemirror/lib/codemirror.css'; // Import the codemirror css
import 'codemirror/mode/javascript/javascript.js'; // Import JavaScript mode

export default {
	name: 'CodeFieldtype',
	props: {
		value: "",
	},
	data() {
		return {
			codeMirrorInstance: null,
			fullScreenMode: false,
		};
	},
	watch: {
		value(newValue) {
			if (this.codeMirrorInstance && newValue !== this.codeMirrorInstance.getValue()) {
				this.codeMirrorInstance.setValue(newValue);
			}
		},
		fullScreenMode: {
			handler: function (fullscreen) {
				this.$nextTick(() => {
					this.$nextTick(() => this.initCodeMirror());
				});
			}
		},
	},
	mounted() {
		this.initCodeMirror();
	},
	methods: {
		initCodeMirror() {
			this.codeMirrorInstance = CodeMirror.fromTextArea(this.$refs.textarea, {
				mode: 'javascript',
				lineNumbers: true,
				theme: 'material',
				lineWrapping: true,
			});

			this.codeMirrorInstance.setValue(this.value);

			this.codeMirrorInstance.on('change', () => {
				this.$emit('input', this.codeMirrorInstance.getValue());
			});
		}
	}
};
</script>
