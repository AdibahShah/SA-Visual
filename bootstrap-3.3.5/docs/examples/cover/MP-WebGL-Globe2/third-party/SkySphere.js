// DO NOT ERASE THIS AREA (START)
var camera, cubeCamera, scene, renderer;
var sphere;

var fov = 85,
isUserInteracting = false,
onMouseDownMouseX = 0, onMouseDownMouseY = 0,
lon = 0, onMouseDownLon = 0,
lat = 0, onMouseDownLat = 0,
phi = 0, theta = 0;

var texture = THREE.ImageUtils.loadTexture( 'Pictures/nebula.jpg', THREE.UVMapping, function () {

	init();
	animate();

} );

function init() {

// Camera 1
	camera = new THREE.PerspectiveCamera( fov, window.innerWidth / window.innerHeight, 1, 1000 );

// Scene
	scene = new THREE.Scene();

// Skysphere 1
	var mesh = new THREE.Mesh( new THREE.SphereGeometry( 1000, 60, 40 ), new THREE.MeshBasicMaterial( { map: texture } ) );
	mesh.scale.x = -1;
	scene.add( mesh );

// Renderer
	renderer = new THREE.WebGLRenderer( { antialias: true } );
	renderer.setPixelRatio( window.devicePixelRatio );
	renderer.setSize( window.innerWidth, window.innerHeight );

// Camera 2
	cubeCamera = new THREE.CubeCamera( 1, 1000, 256 );
	cubeCamera.renderTarget.minFilter = THREE.LinearMipMapLinearFilter;
	scene.add( cubeCamera );

// add to target element
	document.body.appendChild( renderer.domElement );

//	Creating the globe
	var material = new THREE.MeshBasicMaterial( { map: THREE.ImageUtils.loadTexture('Pictures/bump.jpg') } );

	sphere = new THREE.Mesh( new THREE.SphereGeometry( 50, 60, 40 ), material );
	scene.add( sphere );	
//
	document.addEventListener( 'mousedown', onDocumentMouseDown, false );
	document.addEventListener( 'mousewheel', onDocumentMouseWheel, false );
	document.addEventListener( 'DOMMouseScroll', onDocumentMouseWheel, false);
	window.addEventListener( 'resize', onWindowResized, false );

	onWindowResized( null );

}

function onWindowResized( event ) {

	renderer.setSize( window.innerWidth, window.innerHeight );
	camera.projectionMatrix.makePerspective( fov, window.innerWidth / window.innerHeight, 1, 1100 );
}

function onDocumentMouseDown( event ) {

	event.preventDefault();

	onPointerDownPointerX = event.clientX;
	onPointerDownPointerY = event.clientY;

	onPointerDownLon = lon;
	onPointerDownLat = lat;

	document.addEventListener( 'mousemove', onDocumentMouseMove, false );
	document.addEventListener( 'mouseup', onDocumentMouseUp, false );

}

function onDocumentMouseMove( event ) {

	lon = ( event.clientX - onPointerDownPointerX ) * 0.1 + onPointerDownLon;
	lat = ( event.clientY - onPointerDownPointerY ) * 0.1 + onPointerDownLat;

}

function onDocumentMouseUp( event ) {

	document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
	document.removeEventListener( 'mouseup', onDocumentMouseUp, false );

}

function onDocumentMouseWheel( event ) {

	// WebKit

	if ( event.wheelDeltaY ) {

		fov -= event.wheelDeltaY * 0.05;

		// Opera / Explorer 9

		} else if ( event.wheelDelta ) {

			fov -= event.wheelDelta * 0.05;

		// Firefox

		} else if ( event.detail ) {

			fov += event.detail * 1.0;

		}

		camera.projectionMatrix.makePerspective( fov, window.innerWidth / window.innerHeight, 1, 1100 );
}

function animate() {

	requestAnimationFrame( animate );
	render();

}

function render() {

	var time = Date.now();

	lon += .15;

	lat = Math.max( - 85, Math.min( 85, lat ) );
	phi = THREE.Math.degToRad( 90 - lat );
	theta = THREE.Math.degToRad( lon );

/*	
 * sphere.position.x = Math.sin( time * 0.001 ) * 30;
 * sphere.position.y = Math.sin( time * 0.0011 ) * 30;
 * sphere.position.z = Math.sin( time * 0.0012 ) * 30;
 *
 * sphere.rotation.x += 0.02;
 * sphere.rotation.y += 0.03;
 */

	camera.position.x = 100 * Math.sin( phi ) * Math.cos( theta );
	camera.position.y = 100 * Math.cos( phi );
	camera.position.z = 100 * Math.sin( phi ) * Math.sin( theta );

	camera.lookAt( scene.position );

	sphere.visible = false; // *cough*

	cubeCamera.updateCubeMap( renderer, scene );

	sphere.visible = true; // *cough*

	renderer.render( scene, camera );
}
// DO NOT ERASE THIS AREA (END)
