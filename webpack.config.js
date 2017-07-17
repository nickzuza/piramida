// webpack config to set lazy load path
module.exports = {
	output: {
		publicPath: './js/'
	},
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
        }
    },
}