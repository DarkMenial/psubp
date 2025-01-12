
<div class="section"></div>
<div class="sectionline"></div>
<div class="container__sidemain">
    <div class="sidebar__sticky">
        <?php foreach ($sections as $sectionId => $section): ?>
            <?php if (!empty($section['content'])): ?>
                <button class="nav-button" data-section="<?php echo $sectionId; ?>"><?php echo $section['title']; ?></button>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="main">
        <?php foreach ($sections as $sectionId => $section): ?>
            <?php if (!empty($section['content'])): ?>
                <section id="<?php echo $sectionId; ?>">
                    <div class="container page_container">
                        <h1><?php echo $section['title']; ?></h1>
                        <p><?php echo $section['content']; ?></p>
                    </div>
                </section>
                <div class="section"></div>
                <div class="sectionline"></div>
                <div class="section"></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
