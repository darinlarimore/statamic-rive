# <img src="readmeAssets/icon.svg" height="50" width="50"> Statamic Rive Field

> Statamic Rive Field is a Statamic addon that accepts an a .riv file upload, displays an animiation preview and gives configuration options for the Rive animation.

## Features

This addon does:
- Upload a .riv Rive file
- Configure settings for the Rive Model
- Display a preview of the Rive animation
- Display file information about the Rive animation

![Editor View](/readmeAssets/editorView.png)

## How to Install

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

``` bash
composer require darinlarimore/statamic-rive
```

## How to Use

### Allow .riv file types in `config/statamic/assets.php`
``` php
'additional_uploadable_extensions' => [
		'riv',
],
```

### Add the field to a blueprint
![Rive Field](/readmeAssets/fieldType.png)

Name the field handle `rive_animation` or whatever you like.

### Configure the field settings
Choose an asset container.
![Rive Field Configuration](/readmeAssets/configure.png)


### Use the field in your template
Use the `rive_animation` handle in your template. The field will have the following properties:
- `url` - The URL of the Rive animation
- `width` - The width of the animation
- `height` - The height of the animation
- `stateMachine` - The state machine of the animation
- `animation` - The timeline name of the animation
- `artboard` - The artboard of the animation
- `shouldDisableRiveListeners` - Whether or not to disable Rive listeners

### Install Rive.js from NPM or CDN
``` bash
npm install @rive-app/canvas
```

### Import Rive.js into your project
``` js
import { Rive } from "@rive-app/canvas";

window.Rive = Rive;
```

### Example Usage
Using Alpine.js to initialize the Rive animation:
``` html
	<div x-data x-init="() => {
		const rive = new window.Rive({
			src: '{{ rive_animation.url }}',
			canvas: $refs.riveCanvas,
			autoplay: true,
			onLoad: () => {
				rive.resizeDrawingSurfaceToCanvas();
			},
			{{ if rive_animation.stateMachine }}
				stateMachines: '{{ rive_animation.stateMachine }}',
			{{ /if }}
			{{ if rive_animation.animation }}
				animations: '{{ rive_animation.animation }}',
			{{ /if }}
			{{ if rive_animation.artboard }}
				artboard: '{{ rive_animation.artboard }}',
			{{ /if }}
			shouldDisableRiveListeners: '{{ rive_animation.shouldDisableRiveListeners }}',
		});
	}">
		<canvas x-ref="riveCanvas" width="{{rive_animation.width}}" height="{{rive_animation.height}}"></canvas>
	</div>
```

