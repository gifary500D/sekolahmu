import http from 'node:http';
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const root = path.dirname(fileURLToPath(import.meta.url));
const port = Number(process.env.PORT || 3000);
const types = { '.html': 'text/html; charset=utf-8', '.js': 'text/javascript; charset=utf-8', '.css': 'text/css; charset=utf-8', '.json': 'application/json; charset=utf-8', '.svg': 'image/svg+xml', '.png': 'image/png', '.ico': 'image/x-icon' };

function safePath(urlPath) {
  const decoded = decodeURIComponent(urlPath.split('?')[0]);
  const requested = decoded === '/' ? '/index.html' : decoded;
  const resolved = path.normalize(path.join(root, requested));
  return resolved.startsWith(root) ? resolved : null;
}

function publicPath(urlPath) {
  const decoded = decodeURIComponent(urlPath.split('?')[0]);
  const resolved = path.normalize(path.join(root, 'public', decoded));
  return resolved.startsWith(path.join(root, 'public')) ? resolved : null;
}

const server = http.createServer((req, res) => {
  const filePath = safePath(req.url || '/');
  if (!filePath) { res.writeHead(400); res.end('Bad request'); return; }
  const publicFilePath = publicPath(req.url || '/');
  const publicExists = publicFilePath && fs.existsSync(publicFilePath) && fs.statSync(publicFilePath).isFile();
  const exists = fs.existsSync(filePath) && fs.statSync(filePath).isFile();
  const fallback = path.join(root, 'index.html');
  const target = publicExists ? publicFilePath : exists ? filePath : fallback;
  fs.readFile(target, (err, data) => {
    if (err) { res.writeHead(500); res.end('Server error'); return; }
    const type = types[path.extname(target)] || 'application/octet-stream';
    res.writeHead(200, { 'Content-Type': type, 'Cache-Control': 'no-store' });
    res.end(data);
  });
});

server.listen(port, '0.0.0.0', () => console.log(`SekolahMu preview listening on 0.0.0.0:${port}`));
