<main class="contenedor seccion contenido-centrado">
    <h1>Nuestro Blog</h1>
    <?php foreach ($blogs as $blog) { ?>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <img loading="lazy" src="/imagenes/<?php echo $blog->imagen; ?>" alt="Texto Entrada Blog">
                </picture>
            </div>

            <?php
            $detallesSinSaltos = str_replace(["\r", "\n"], ' ', $blog->detalles); // Evita que se muestren los saltos de linea en el navegador sin que afecte a la BD.
            $limiteDetalles = strlen($detallesSinSaltos) > 110 ? substr($detallesSinSaltos, 0, 110) . '...' : $detallesSinSaltos;
            ?>

            <div class="texto-entrada">
                <a href="/entrada?id=<?php echo $blog->id ?>">
                    <h4> <?php echo $blog->titulo ?> </h4>
                    <p>Escrito el: <span> <?php echo $blog->fecha ?> </span> Por: <span> <?php echo $blog->autor ?> </span></p>
                    <p>
                        <?php echo $limiteDetalles ?>
                    </p>
                </a>
            </div>
        </article>

    <?php } ?>

    <a href="/" class="boton-verde">Volver</a>
</main>