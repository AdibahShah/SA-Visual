var width = window.innerWidth;
var height = window.innerHeight;

// define renderer and scene
var renderer = new THREE.WebGLRenderer({antialias: true});
renderer.setSize(width, height);
document.body.appenChild(renderer.domElement);

var scene = new THREE.Scene;

// SkySphere
/*var geometry = new THREE.SphereGeometry(3000, 60, 40);
var uniforms = {texture: {type: 't', value: loadTexture('Pictures/milkyway')}};

var material = new THREE.ShaderMaterial({
	uniforms: uniforms,
	vertexShader: document.getElementById('sky-vertex').textContent,
	fragmentShader: document.getElementById('sky-fragment').textContent
});

skyBox = new THREE.Mesh (geometry, material);
skyBox.scale.set (-1, 1, 1);
skyBox.eulerOrder ='XZY';
skyBox.renderDepth = 1000.0;
scene.add(skyBox);*/

var cubeGeometry = new THREE.CubeGeometry(100, 100, 100);
var cubeMaterial = new THREE.MeshLambertMaterial({color: 0x1ec876});
var cube = new THREE.Mes(cubeGeomtry, cubeMaterial);

cube.rotation.y = Math.PI*45/180;
scene.add (cube);

// define camera
var camera = new THREE.PerspectiveCamera(45, width/height, 0.1, 10000);
camera.position.y = 160;
camera.position.z = 400;
scene.add(camera);
renderer.render(scene,camera);
camera.lookAt(cube.position);

