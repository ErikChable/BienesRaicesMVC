<article class="entrada-blog">
    <?php foreach ($blogs as $blog) { ?>
        <div class="imagen">
            <picture>
                <img loading="lazy" src="/imagenes/<?php echo $blog->imagen; ?>" alt="Texto Entrada Blog">
            </picture>
        </div>

        <?php
        $limiteTitulo = strlen($blog->titulo) > 38 ? substr($blog->titulo, 0, 38) . '...' : $blog->titulo;

        $descripcionSinSaltos = str_replace(["\r", "\n"], ' ', $blog->detalles); // Evita que se muestren los saltos de linea en el navegador sin que afecte a la BD.
        $limiteDetalles = strlen($descripcionSinSaltos) > 100 ? substr($descripcionSinSaltos, 0, 100) . '...' : $descripcionSinSaltos;
        ?>

        <div class="texto-entrada">
            <a href="/entrada">
                <h4> <?php echo $limiteTitulo ?> </h4>
                <p class="informacion-meta">Escrito el: <span> <?php echo $blog->fecha ?> </span> Por: <span> <?php echo $blog->autor; ?> </span></p>

                <p> <?php echo $limiteDetalles; ?> </p>
            </a>
        </div>
    <?php }; ?>
</article>