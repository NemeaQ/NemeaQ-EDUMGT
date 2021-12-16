<div class="box"><h1>Профиль</h1>
    <div class="box-transparent profile">
        <div class="profile__skin">
            <canvas class="skin-3d" width="300" height="460"
                    style="cursor:move;width:300px;background-color:antiquewhite;" data-skin-hash="85986e8101adf9be"
                    data-model="slim"
                    data-animate="false" data-theta="-34" data-phi="-117" data-time="90"></canvas>
            <script type="module">
                // import * as THREE from 'https://cdn.skypack.dev/three@0.131.1';

                const TAU = 2 * Math.PI;
                const EPSILON = 1e-3;

                function radians(d) {
                    return d * (TAU / 360);
                }

                function textureUrl(hash) {
                    return 'https://texture.namemc.com/92/89/9289b6cec8882497.png';
                }

                function toCanvas(image, x, y, w, h) {
                    x = (typeof x === 'undefined' ? 0 : x);
                    y = (typeof y === 'undefined' ? 0 : y);
                    w = (typeof w === 'undefined' ? image.width : w);
                    h = (typeof h === 'undefined' ? image.height : h);
                    let canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    let ctx = canvas.getContext('2d');
                    ctx.drawImage(image, x, y, w, h, 0, 0, w, h);
                    return canvas;
                }

                function makeOpaque(image) {
                    let canvas = toCanvas(image);
                    let ctx = canvas.getContext('2d');
                    let data = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    let pixels = data.data;
                    for (let p = 3; p < pixels.length; p += 4) {
                        pixels[p] = 255;
                    }
                    ctx.putImageData(data, 0, 0);
                    return canvas;
                }

                let renderState;
                let canvas3d = document.getElementsByClassName('skin-3d')[0];

                function render() {
                    canvas3d.setAttribute('data-time', Math.round(renderState.time) % 360);
                    let angle = Math.sin(radians(renderState.time));
                    renderState.model.rotation.x = -radians(18) * angle;
                    // renderState.model.children[2].rotation.x = -radians(18) * angle;
                    // renderState.model.children[3].rotation.x = radians(18) * angle;
                    // renderState.model.children[4].rotation.x = radians(20) * angle;
                    // renderState.model.children[5].rotation.x = -radians(20) * angle;
                    if (renderState.model.children[6]) {
                        let capeAngle = Math.sin(radians(renderState.time / 4));
                        renderState.model.children[6].rotation.x = radians(18) - radians(6) * capeAngle;
                    }
                    renderState.renderer.render(renderState.scene, renderState.camera);
                }

                function enableRotation(renderState) {
                    function startRotation(t, id) {
                        renderState.dragState[id] = {
                            x: t.screenX,
                            y: t.screenY
                        };
                    }

                    function rotate(t, id) {
                        if (!renderState.dragState[id]) {
                            return false;
                        }
                        let result = true;
                        renderState.theta += t.screenX - renderState.dragState[id].x;
                        renderState.phi += t.screenY - renderState.dragState[id].y;
                        renderState.canvas.setAttribute('data-theta', (renderState.theta % 360).toString());
                        renderState.canvas.setAttribute('data-phi', (renderState.phi % 360).toString());
                        if (renderState.phi < -90) {
                            renderState.phi = -90;
                            result = false;
                        } else if (renderState.phi > 90) {
                            renderState.phi = 90;
                            result = false;
                        }
                        renderState.model.rotation.y = radians(renderState.theta);
                        renderState.model.rotation.x = radians(renderState.phi);
                        renderState.renderer.render(renderState.scene, renderState.camera);
                        renderState.dragState[id].x = t.screenX;
                        renderState.dragState[id].y = t.screenY;
                        return result;
                    }

                    function endRotation(t, id) {
                        delete renderState.dragState[id];
                    }

                    renderState.canvas.onmousedown = function (e) {
                        e.preventDefault();
                        startRotation(e, 'mouse');
                    }
                    ;
                    window.onmousemove = function (e) {
                        rotate(e, 'mouse');
                    }
                    ;
                    window.onmouseup = function (e) {
                        endRotation(e, 'mouse');
                    }
                    ;
                    renderState.canvas.ontouchstart = function (e) {
                        for (let i = 0; i < e.changedTouches.length; i++) {
                            startRotation(e.changedTouches[i], e.changedTouches[i].identifier);
                        }
                    }
                    ;
                    renderState.canvas.ontouchmove = function (e) {
                        let result = false;
                        for (let i = 0; i < e.changedTouches.length; i++) {
                            if (rotate(e.changedTouches[i], e.changedTouches[i].identifier)) {
                                result = true;
                            } else {
                                delete renderState.dragState[e.changedTouches[i].identifier];
                            }
                        }
                        if (result) {
                            e.preventDefault();
                        }
                    }
                    ;
                    renderState.canvas.ontouchend = renderState.canvas.ontouchcancel = function (e) {
                        for (let i = 0; i < e.changedTouches.length; i++) {
                            endRotation(e.changedTouches[i], e.changedTouches[i].identifier);
                        }
                    }
                    ;
                }

                let renderer;

                function buildMinecraftModel(skinHash, capeHash) {
                    let skinImage = new Image();
                    skinImage.crossOrigin = '';
                    skinImage.src = textureUrl(skinHash);
                    skinImage.onload = function () {
                    }

                    if (skinImage.width < 64 || skinImage.height < 32) {
                        return null;
                    }
                    //let version = (skinImage.height >= 64 ? 1 : 0);
                    //let cs = capeImage ? capeScale(capeImage.height) : null;
                    //let opaqueSkinCanvas = makeOpaque(skinImage);
                    //let transparentSkinCanvas = toCanvas(skinImage);
                    //let hasAlpha = hasAlphaLayer(skinImage);
                    // let headGroup = new THREE.Object3D();
                    // headGroup.position.x = 0;
                    // headGroup.position.y = 12;
                    // headGroup.position.z = 0;
                    // let box = new THREE.BoxGeometry(8, 8, 8, 8, 8, 8);
                    // let headMesh = colorFaces(box, opaqueSkinCanvas, skinLayout[version]['head'][0]);
                    // headGroup.add(headMesh);
                    // if (hasAlpha) {
                    //     box = new THREE.BoxGeometry(9, 9, 9, 8, 8, 8);
                    //     let hatMesh = colorFaces(box, transparentSkinCanvas, skinLayout[version]['head'][1]);
                    //     hatMesh && headGroup.add(hatMesh);
                    // }
                    // let torsoGroup = new THREE.Object3D();
                    // torsoGroup.position.x = 0;
                    // torsoGroup.position.y = 2;
                    // torsoGroup.position.z = 0;
                    // box = new THREE.BoxGeometry(8 + EPSILON, 12 + EPSILON, 4 + EPSILON, 8, 12, 4);
                    // let torsoMesh = colorFaces(box, opaqueSkinCanvas, skinLayout[version]['torso'][0]);
                    // torsoGroup.add(torsoMesh);
                    // if (version >= 1 && hasAlpha) {
                    //     box = new THREE.BoxGeometry(8.5 + EPSILON, 12.5 + EPSILON, 4.5 + EPSILON, 8, 12, 4);
                    //     let jacketMesh = colorFaces(box, transparentSkinCanvas, skinLayout[version]['torso'][1]);
                    //     jacketMesh && torsoGroup.add(jacketMesh);
                    // }
                    // let rightArmGroup = new THREE.Object3D();
                    // rightArmGroup.position.x = slim ? -5.5 : -6;
                    // rightArmGroup.position.y = 6;
                    // rightArmGroup.position.z = 0;
                    // let rightArmMesh;
                    // if (slim) {
                    //     box = new THREE.BoxGeometry(3, 12, 4, 3, 12, 4).translate(0, -4, 0);
                    //     rightArmMesh = colorFaces(box, opaqueSkinCanvas, skinLayout[version]['armRS'][0]);
                    // } else {
                    //     box = new THREE.BoxGeometry(4, 12, 4, 4, 12, 4).translate(0, -4, 0);
                    //     rightArmMesh = colorFaces(box, opaqueSkinCanvas, skinLayout[version]['armR'][0]);
                    // }
                    // rightArmGroup.add(rightArmMesh);
                    // if (version >= 1 && hasAlpha) {
                    //     let rightSleeveMesh;
                    //     if (slim) {
                    //         box = new THREE.BoxGeometry(3.5 + EPSILON * 4, 12.5 + EPSILON * 4, 4.5 + EPSILON * 4, 3, 12, 4).translate(0, -4, 0);
                    //         rightSleeveMesh = colorFaces(box, transparentSkinCanvas, skinLayout[version]['armRS'][1]);
                    //     } else {
                    //         box = new THREE.BoxGeometry(4.5 + EPSILON * 4, 12.5 + EPSILON * 4, 4.5 + EPSILON * 4, 4, 12, 4).translate(0, -4, 0);
                    //         rightSleeveMesh = colorFaces(box, transparentSkinCanvas, skinLayout[version]['armR'][1]);
                    //     }
                    //     rightSleeveMesh && rightArmGroup.add(rightSleeveMesh);
                    // }
                    // let leftArmGroup = new THREE.Object3D();
                    // leftArmGroup.position.x = slim ? 5.5 : 6;
                    // leftArmGroup.position.y = 6;
                    // leftArmGroup.position.z = 0;
                    // let leftArmMesh;
                    // if (slim) {
                    //     box = new THREE.BoxGeometry(3, 12, 4, 3, 12, 4).translate(0, -4, 0);
                    //     leftArmMesh = colorFaces(box, opaqueSkinCanvas, skinLayout[version]['armLS'][0]);
                    // } else {
                    //     box = new THREE.BoxGeometry(4, 12, 4, 4, 12, 4).translate(0, -4, 0);
                    //     leftArmMesh = colorFaces(box, opaqueSkinCanvas, skinLayout[version]['armL'][0]);
                    // }
                    // leftArmGroup.add(leftArmMesh);
                    // if (version >= 1 && hasAlpha) {
                    //     let leftSleeveMesh;
                    //     if (slim) {
                    //         box = new THREE.BoxGeometry(3.5 + EPSILON * 4, 12.5 + EPSILON * 4, 4.5 + EPSILON * 4, 3, 12, 4).translate(0, -4, 0);
                    //         leftSleeveMesh = colorFaces(box, transparentSkinCanvas, skinLayout[version]['armLS'][1]);
                    //     } else {
                    //         box = new THREE.BoxGeometry(4.5 + EPSILON * 4, 12.5 + EPSILON * 4, 4.5 + EPSILON * 4, 4, 12, 4).translate(0, -4, 0);
                    //         leftSleeveMesh = colorFaces(box, transparentSkinCanvas, skinLayout[version]['armL'][1]);
                    //     }
                    //     leftSleeveMesh && leftArmGroup.add(leftSleeveMesh);
                    // }
                    // let rightLegGroup = new THREE.Object3D();
                    // rightLegGroup.position.x = -2;
                    // rightLegGroup.position.y = -4;
                    // rightLegGroup.position.z = 0;
                    // box = new THREE.BoxGeometry(4, 12, 4, 4, 12, 4).translate(0, -6, 0);
                    // let rightLegMesh = colorFaces(box, opaqueSkinCanvas, skinLayout[version]['legR'][0]);
                    // rightLegGroup.add(rightLegMesh);
                    // if (version >= 1 && hasAlpha) {
                    //     box = new THREE.BoxGeometry(4.5 + EPSILON * 2, 12.5 + EPSILON * 2, 4.5 + EPSILON * 2, 4, 12, 4).translate(0, -6, 0);
                    //     let rightPantMesh = colorFaces(box, transparentSkinCanvas, skinLayout[version]['legR'][1]);
                    //     rightPantMesh && rightLegGroup.add(rightPantMesh);
                    // }
                    // let leftLegGroup = new THREE.Object3D();
                    // leftLegGroup.position.x = 2;
                    // leftLegGroup.position.y = -4;
                    // leftLegGroup.position.z = 0;
                    // box = new THREE.BoxGeometry(4, 12, 4, 4, 12, 4).translate(0, -6, 0);
                    // let leftLegMesh = colorFaces(box, opaqueSkinCanvas, skinLayout[version]['legL'][0]);
                    // leftLegGroup.add(leftLegMesh);
                    // if (version >= 1 && hasAlpha) {
                    //     box = new THREE.BoxGeometry(4.5 + EPSILON * 3, 12.5 + EPSILON * 3, 4.5 + EPSILON * 3, 4, 12, 4).translate(0, -6, 0);
                    //     let leftPantMesh = colorFaces(box, transparentSkinCanvas, skinLayout[version]['legL'][1]);
                    //     leftPantMesh && leftLegGroup.add(leftPantMesh);
                    // }
                    //
                    const geometry = new THREE.BoxGeometry(8, 8, 8);
                    const material = new THREE.MeshBasicMaterial({color: 0x0000ff});
                    //
                    //
                    //
                    // playerGroup.add(headGroup);
                    // playerGroup.add(torsoGroup);
                    // playerGroup.add(rightArmGroup);
                    // playerGroup.add(leftArmGroup);
                    // playerGroup.add(rightLegGroup);
                    // playerGroup.add(leftLegGroup);
                    // if (capeImage) {
                    //     let capeCanvas = makeOpaque(capeImage);
                    //     let capeGroup = new THREE.Object3D();
                    //     capeGroup.position.x = 0;
                    //     capeGroup.position.y = 8;
                    //     capeGroup.position.z = -2;
                    //     capeGroup.rotation.y += radians(180);
                    //     let capeMesh;
                    //     box = new THREE.BoxGeometry(10, 16, 1, 10 * cs, 16 * cs, cs).translate(0, -8, 0.5);
                    //     capeMesh = colorFaces(box, capeCanvas, {
                    //         left: {
                    //             x: 11 * cs,
                    //             y: cs,
                    //             w: cs,
                    //             h: 16 * cs
                    //         },
                    //         right: {
                    //             x: 0,
                    //             y: cs,
                    //             w: cs,
                    //             h: 16 * cs
                    //         },
                    //         top: {
                    //             x: cs,
                    //             y: 0,
                    //             w: 10 * cs,
                    //             h: cs
                    //         },
                    //         bottom: {
                    //             x: 11 * cs,
                    //             y: cs - 1,
                    //             w: 10 * cs,
                    //             h: -cs
                    //         },
                    //         front: {
                    //             x: cs,
                    //             y: cs,
                    //             w: 10 * cs,
                    //             h: 16 * cs
                    //         },
                    //         back: {
                    //             x: 12 * cs,
                    //             y: cs,
                    //             w: 10 * cs,
                    //             h: 16 * cs
                    //         }
                    //     });
                    //     capeGroup.add(capeMesh);
                    //     playerGroup.add(capeGroup);
                    // }
                    // if (flip) {
                    //     playerGroup.rotation.z += radians(180);
                    // }


                    return new THREE.Mesh(geometry, material);
                }

                function renderSkinHelper(canvas, animate, theta, phi, time, model) {
                    if (renderState) {
                        renderState.canvas = canvas;
                        renderState.scene.remove(renderState.model);
                        renderState.model = model;
                        renderState.scene.add(model);
                        renderState.animate = animate;
                        renderState.model.rotation.y = radians(theta);
                        renderState.model.rotation.x = radians(phi);
                        render();
                        return;
                    }
                    if (!renderer) {
                        renderer = new THREE.WebGLRenderer({canvas: canvas, alpha: true, antialias: true});
                    }
                    renderState = {
                        canvas: canvas,
                        animate: animate,
                        model: model,
                        theta: theta,
                        phi: phi,
                        scene: new THREE.Scene(),
                        camera: new THREE.PerspectiveCamera(38, 300 / 600, 60 - 20, 60 + 20),
                        renderer: renderer,
                        dragState: {},
                        time: time
                    };
                    renderState.camera.position.x = 0;
                    renderState.camera.position.z = 60;
                    renderState.camera.position.y = 0;
                    renderState.camera.lookAt(new THREE.Vector3(0, 0, 0));
                    renderState.scene.add(model);
                    let ambLight = new THREE.AmbientLight(0xFFFFFF, 0.7);
                    let dirLight = new THREE.DirectionalLight(0xFFFFFF, 0.3);
                    dirLight.position.set(0.67763, 0.28571, 0.67763);
                    renderState.scene.add(ambLight);
                    renderState.scene.add(dirLight);
                    renderState.model.rotation.y = radians(theta);
                    renderState.model.rotation.x = radians(phi);
                    enableRotation(renderState);
                    render();
                }

                let modelCache = {};

                function drawSkin3D() {
                    if (!canvas3d)
                        return;
                    let slim = canvas3d.getAttribute('data-model') === 'slim';
                    let skinHash = canvas3d.getAttribute('data-skin-hash');
                    let capeHash = canvas3d.getAttribute('data-cape-hash');
                    let flip = canvas3d.getAttribute('data-flip') === 'true';
                    let animate = true;
                    let theta = canvas3d.getAttribute('data-theta') ? parseFloat(canvas3d.getAttribute('data-theta')) : 30;
                    let phi = canvas3d.getAttribute('data-phi') ? parseFloat(canvas3d.getAttribute('data-phi')) : 21;
                    let time = canvas3d.getAttribute('data-time') ? parseFloat(canvas3d.getAttribute('data-time')) : 90;
                    canvas3d.getAttribute('data-model', slim ? 'slim' : 'classic');
                    canvas3d.getAttribute('data-theta', theta);
                    canvas3d.getAttribute('data-phi', phi);
                    canvas3d.getAttribute('data-time', time);

                    let model = buildMinecraftModel(skinHash, capeHash);

                    renderSkinHelper(canvas3d, animate, theta, phi, time, model);
                }


                function scaleSkinsToDevice() {
                    if (typeof window.devicePixelRatio === 'number' && window.devicePixelRatio !== 1.0) {
                        let ratio = Math.min(2.0, window.devicePixelRatio);
                        let i = 0, len = canvas3d.length;
                        for (; i < len; i++) {
                            canvas3d[i].width *= ratio;
                            canvas3d[i].height *= ratio;
                        }
                    } else {
                        document.querySelector('img[data-src]').forEach(function (e) {
                            e.src = e.getAttribute('data-src');
                        });
                    }
                }

                scaleSkinsToDevice();
                drawSkin3D();

            </script>
        </div>
        <div class="profile__info">
            <?php if (!isset($_SESSION['account']['uuid'])): ?>
                <div class="alert alert--notice">
                    Выполните эту команду в игре чтобы привязать свой игровой аккаунт:
                    <button id="linkCopyBtn" class="btn btn-white"><code>
                            <svg class="btn__icon" viewBox="0 0 210 210">
                                <path d="M169 0H80C67 0 57 10 57 23v3H42c-13 0-24 11-24 23v138c0 13 11 23 24 23h88c13 0 23-10 23-23v-3h16c12 0 23-10 23-23V23c0-13-11-23-23-23zm-31 187c0 4-4 8-8 8H42c-5 0-9-4-9-8V49c0-4 4-8 9-8h88c4 0 8 4 8 8v138zm39-26c0 4-4 8-8 8h-16V49c0-12-10-23-23-23H72v-3c0-4 4-8 8-8h89c4 0 8 4 8 8v138z"
                                      fill="current"/>
                            </svg>
                            /link <?= $_SESSION['account']['token'] ?></code></button>
                </div>
            <?php endif; ?>
            <div>
                <h2>Персональная информация</h2>
                <p><span>Id: </span><?= $_SESSION['account']['id'] ?></p>
                <p><span>Email: </span><?= $_SESSION['account']['email'] ?></p>
                <?php if (isset($_SESSION['account']['uuid'])): ?>
                    <h2>Статистика</h2>
                    <h2>Предупреждения</h2>
                    <h2>Кланы</h2>
                <?php endif; ?>
                <!--            <pre><code>--><?php //= print_r($_SESSION['account']) ?><!--</code></pre>-->
            </div>
        </div>
    </div>
</div>