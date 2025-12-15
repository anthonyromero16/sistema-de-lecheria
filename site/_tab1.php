        <?php
        use yii\helpers\Url;
        $this->registerJsFile("@web/js/carrusel", ['depends' => [\yii\web\JqueryAsset::class]]);
        ?>
        
        <section id="tab1" class="tab-content active">
            <h2>Diferentes razas bovinas que se utilizan en nuestra producción</h2>

            <div class="texto_raza">
                <p>
                    En Lechería Don Joaquín trabajamos con razas bovinas cuidadosamente seleccionadas por su alta calidad, productividad y adaptación al clima de nuestras fincas.
                    Cada raza cumple un papel importante dentro de nuestro sistema de producción, garantizando leche de excelente sabor, pureza y valor nutricional.

                    Nuestras vacas provienen de líneas genéticas reconocidas por su eficiencia lechera, resistencia y buen temperamento, lo que permite mantener un manejo sostenible y respetuoso con los animales.
                    Gracias a la combinación de distintas razas especializadas, logramos equilibrar la cantidad y calidad de la leche, además de fortalecer la salud y bienestar del ganado.

                    En esta sección te presentaremos las principales razas con las que trabajamos, sus características, ventajas productivas y cómo contribuyen al éxito de nuestra lechería.
                    Nuestro compromiso es seguir mejorando cada generación de animales para ofrecer siempre los mejores productos lácteos del campo panameño.
                </p>
            </div>

            <!-- CARRUSEL -->
            <div class="carrusel-container">
                <button class="carrusel-btn prev">&lt;</button>

                <div class="carrusel-slide">

                    <div class="carrusel-item active">
                        <img src="<?= Yii::$app->request->baseUrl ?>/images/imagenes-razas/Vaca_Holstein_Carrusel.jpg">
                        <h4>Holstein</h4>
                        <p>La raza Holstein, originaria de los Países Bajos, es reconocida mundialmente por su altísima producción de leche.
                           Estas vacas destacan por su gran tamaño, temperamento dócil y su característico pelaje blanco con manchas negras.

                           Aunque su leche tiene un contenido moderado de grasa, la cantidad que producen por vaca es excepcional,
                           lo que las convierte en la raza más utilizada en sistemas lecheros intensivos.

                           En nuestras granjas, la Holstein es fundamental para garantizar un alto volumen de leche diaria
                           y mantener una base productiva estable.</p>
                    </div>

                    <div class="carrusel-item">
                        <img src="<?= Yii::$app->request->baseUrl ?>/images/imagenes-razas/Vaca_sindhi_Carrusel.png">
                        <h4>Sindhi</h4>
                        <p>La raza Sindhi, originaria de Pakistán, es una de las razas cebuinas más valoradas
                           por su excelente adaptación a climas cálidos y húmedos.

                           Posee una gran resistencia a enfermedades tropicales, buena fertilidad y longevidad.
                           Aunque su producción de leche es menor comparada con la Holstein, su leche es rica en sólidos y grasa,
                           ideal para la elaboración de derivados lácteos.

                           En nuestras fincas, el Sindhi se utiliza para mejorar la rusticidad del hato
                           y mantener la producción constante incluso en condiciones ambientales exigentes.</p>
                    </div>

                    <div class="carrusel-item">
                        <img src="<?= Yii::$app->request->baseUrl ?>/images/imagenes-razas/Vaca_jersey_Carrusel.jpg">
                        <h4>Jersey</h4>
                        <p>La raza Jersey, proveniente de la Isla de Jersey en Inglaterra, es conocida por producir leche
                           con un alto contenido de grasa y proteína, ideal para fabricar quesos, mantequilla y otros productos lácteos de calidad.

                           Son vacas de tamaño pequeño a mediano, muy eficientes en el uso del alimento y de temperamento tranquilo.

                           En nuestras granjas, la Jersey se emplea para mejorar la calidad composicional de la leche
                           y equilibrar la producción total del hato junto con otras razas.</p>
                    </div>

                </div>

                <button class="carrusel-btn next">&gt;</button>
            </div>

            <!-- ANIMACIÓN ORDEÑO -->
            <div class="ordeño-container">
                <h3>Haz clic en la vaca para ordeñarla</h3>

                <div class="vaca" id="vaca">
                    <div class="cuerpo"></div>

                    <div class="cabeza">
                        <div class="hocico"></div>
                        <div class="ojo izquierdo"></div>
                        <div class="ojo derecho"></div>
                        <div class="cuerno izquierdo"></div>
                        <div class="cuerno derecho"></div>
                        <div class="oreja izquierda"></div>
                        <div class="oreja derecha"></div>
                    </div>

                    <div class="ubre">
                        <div class="gota" id="gota"></div>
                    </div>

                    <div class="pata delantera"></div>
                    <div class="pezuña delantera"></div>
                    <div class="pata trasera"></div>
                    <div class="pezuña trasera"></div>

                    <div class="cola">
                        <div class="pelo"></div>
                    </div>
                </div>
            </div>
        </section>