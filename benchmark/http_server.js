var http = require('http');

var app = function (req, res) {
  res.writeHead(200, {
    'Content-Type': 'text/html'
  });
  res.end('hello world');
};

var server = http.createServer(app);

server.listen(9502, function() {
  console.log("Server running at http://127.0.0.1:9502");
});