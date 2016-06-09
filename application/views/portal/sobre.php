<?php portal_template_set('title', 'Sobre nosotros') ?>

<div itemscope="https://schema.org/Person">
    <h3>¿Quiénes somos?</h3>
    <div>
        <p>
            Mejor dicho, soy. Futuro desarrollador de aplicaciones, de
            <span itemprop="address" itemscope="https://schema.org/PostalAddress">
                <span itemprop="addressLocality">Sanlúcar de Barameda</span>,
                <span itemprop="addressRegion">Cádiz</span>
            </span>.
            Estudiante en el
            <span itemprop="affiliation" itemscope="https://schema.org/Organization">
                <span itemprop="name">IES Doñana</span>
            </span>,
            y apasionado de los videojuegos.
        </p>
        <?= img(array('src'   => 'images/about/donana.jpg',
                      'class' => 'about',
                      'alt'   => 'IES Doñana')) ?>
    </div>

    <h3>¿Qué nos apasiona?</h3>
    <div>
        <p>
            <span itemprop="description">
                Al ser una persona muy perfeccionista en lo técnico, la programación es un
                mundo perfecto, ya que el mínimo error puede llevar a fallos. Aunque, por
                otra parte, soy negado al estilo y la apariencia.
            </span>
        </p>
        <?= img(array('src'   => 'images/about/programar.jpg',
                      'class' => 'about',
                      'alt'   => 'Programación')) ?>
    </div>

    <h3>¿Qué ofrecemos?</h3>
    <div>
        <p>
            De toda la vida han existido los libros tipo "elige tu propia aventura",
            yendo de página en página. Ahora, ese mundo lo llevamos a las nuevas tecnologías
            para transportarnos de mundo a mundo con tan solo clicks.
        </p>
        <?= img(array('src'   => 'images/about/elige.jpg',
                      'class' => 'about',
                      'alt'   => 'Libros')) ?>
    </div>
</div>
