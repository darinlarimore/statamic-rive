module.exports = {
	content: ['./resources/**/*'],
	corePlugins: {
		preflight: false,
	},
	prefix: 'r-',
	darkMode: ['variant', ['html[class*="dark"] &']],
}
