document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("three-hero-canvas");
    if (!canvas) return;

    // 1. Scene Setup
    const scene = new THREE.Scene();
    
    // 2. Camera Setup
    const camera = new THREE.PerspectiveCamera(
        45, 
        window.innerWidth / window.innerHeight, 
        0.1, 
        1000
    );
    // Position camera closer
    camera.position.set(0, 0, 5); 

    // 3. Renderer Setup
    const renderer = new THREE.WebGLRenderer({ 
        canvas: canvas, 
        alpha: true, 
        antialias: true 
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.outputEncoding = THREE.sRGBEncoding;

    // 4. Lighting
    // Dark moody lighting matching the reference image
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.1); 
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xff0000, 3); // Intense red light
    directionalLight.position.set(5, 5, -2);
    scene.add(directionalLight);
    
    // Slight cyan for contrast, but kept very low to preserve the red moody look
    const fillLight = new THREE.DirectionalLight(0x00ffff, 0.2); 
    fillLight.position.set(-5, 0, -2);
    scene.add(fillLight);
    
    // Direct back light hitting the back of the suit (from camera perspective)
    const frontLight = new THREE.DirectionalLight(0xff0000, 1.5); 
    frontLight.position.set(0, 0, 5);
    scene.add(frontLight);

    // Mouse Tracking Setup
    let mouseX = 0;
    let mouseY = 0;
    let targetX = 0;
    let targetY = 0;

    const windowHalfX = window.innerWidth / 2;
    const windowHalfY = window.innerHeight / 2;

    document.addEventListener('mousemove', (event) => {
        mouseX = (event.clientX - windowHalfX);
        mouseY = (event.clientY - windowHalfY);
    });

    // 5. Load GLTF Model
    const loader = new THREE.GLTFLoader();
    let spidermanMixer = null; 
    let spidermanModel = null;
    
    const clock = new THREE.Clock();

    loader.load(
        'assets/models/spiderman_homepage.glb',
        (gltf) => {
            spidermanModel = gltf.scene;
            
            // Macro-scale: Focus heavily on the upper body/back and fill the screen
            // Scaled up massively and moved lower to STRICTLY frame the upper back/shoulders
            spidermanModel.position.set(0, -48, -5); 
            spidermanModel.scale.set(28, 28, 28); 
            
            // Rotate to show the back (facing away from camera)
            spidermanModel.rotation.y = Math.PI; 

            scene.add(spidermanModel);

            // Play animations if they exist in the GLB
            if (gltf.animations && gltf.animations.length > 0) {
                spidermanMixer = new THREE.AnimationMixer(spidermanModel);
                const action = spidermanMixer.clipAction(gltf.animations[0]);
                action.play();
            }
        },
        (xhr) => {
            console.log((xhr.loaded / xhr.total * 100) + '% loaded');
        },
        (error) => {
            console.error('An error happened loading the Spider-Man model', error);
        }
    );

    // 6. Animation Loop
    const tick = () => {
        const delta = clock.getDelta();

        if (spidermanMixer) {
            spidermanMixer.update(delta);
        }

        // Mouse Parallax Effect - Extemely subtle, almost static
        targetX = mouseX * 0.00003;
        targetY = mouseY * 0.00003;

        if (spidermanModel) {
            // Smoothly interpolate rotation (lerp) facing away
            // The model's base rotation is Math.PI (facing backwards)
            spidermanModel.rotation.y += 0.01 * (Math.PI + targetX - spidermanModel.rotation.y);
            spidermanModel.rotation.x += 0.01 * (targetY - spidermanModel.rotation.x);
            
            // Very slow, extremely subtle floating effect
            spidermanModel.position.y = -48 + Math.sin(clock.getElapsedTime() * 1) * 0.02; 
        }

        renderer.render(scene, camera);
        window.requestAnimationFrame(tick);
    };

    tick();

    // 7. Handle Window Resize
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
});
