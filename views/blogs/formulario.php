<fieldset>
    <legend>Informacion General</legend>

    <label for="titulo">Titulo:</label>
    <input
        type="text"
        id="titulo"
        name="blog[titulo]"
        placeholder="Titulo del Blog"
        value="<?php echo s($blog->titulo); ?>">

    <label for="autor">Autor:</label>
    <input
        type="text"
        id="autor"
        name="blog[autor]"
        placeholder="Nombre del Autor"
        value="<?php echo s($blog->autor); ?>">

    <label for="imagen">Imagen:</label>
    <input
        type="file"
        id="imagen"
        accept="image/jpeg, image/png"
        name="blog[imagen]">

    <?php if ($blog->imagen) : ?>
        <img src="/imagenes/<?php echo $blog->imagen ?>" class="imagen-small">
    <?php endif; ?>

    <label for="detalles">Detalles:</label>
    <textarea id="detalles" name="blog[detalles]"><?php echo s($blog->detalles); ?></textarea>

</fieldset>