module.exports = {
  transpileDependencies: true,
  devServer: {
    port: 8080,
  },
};

module.exports = {
  devServer: {
    proxy: 'http://127.0.0.1:8000'
  }
}