import '../css/main.css'
import Fieldtype from './components/Rive.vue'

Statamic.booting(() => {
	Statamic.$components.register('rive-fieldtype', Fieldtype)
})
