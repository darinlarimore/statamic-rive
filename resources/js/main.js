import '../css/main.css'
import RiveFieldtype from './components/Rive.vue'

Statamic.booting(() => {
	Statamic.$components.register('rive-fieldtype', RiveFieldtype)
})
