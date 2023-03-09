var STATIC_FILES = [
			'/',
			'/learningxpwa/',
			'http://localhost/learningxpwa/wp-includes/css/dashicons.min.css?ver=6.0.1',];
console.log(STATIC_FILES);
self.addEventListener('install', function (event) {
	console.log('[Service Worker] Installing Service Worker ...', event);
	event.waitUntil(
		caches.open( 'static' )
		.then(function (cache) {
			/* console.log("Precaching app shell"); */
			cache.addAll(STATIC_FILES);
		})
	);
	/* event.waitUntil(
		caches.open( 'dynamic' )
		.then(function (cache) {
			cache.addAll(DYNAMICCACHE);
		})
	); */
});

self.addEventListener('activate', function (event) {
	console.log('[Service Worker] Activating Service Worker ....', event);
	return self.clients.claim();
	/* event.waitUntil(
		caches.keys()
		.then(function (keyList) {
			return Promise.all(keyList.map(function (key) {
				if (key !== "static") {
					console.log('[Service Worker] Removing old cache.', key);
					return caches.delete(key);
				}
			}));
		})
	);
	return self.clients.claim(); */
});

self.addEventListener("fetch", function (event) {
	console.log(event.request.url);
	event.respondWith(
		caches.match( event.request ).then(function (response){
			if( response ){
				return response;
			}else{
				return fetch( event.request );
			}
		})
	);
});

/* var dbPromise = idb.open('storedata-test',1,function( db ){ 
	//storedata-test is the database of the object indexed db;
	db.createObjectStore('testtable',{keyPath:'id'});//firstarg table
}); */

/* self.addEventListener('fetch', function (event){
	event.respondWith(fetch(event.request).then(function(res){
		console.log(res);
	}));
}); */
