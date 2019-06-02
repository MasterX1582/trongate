<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CJ Patoilo">
        <meta name="description" content="Milligram provides a minimal setup of styles for a fast and clean starting point. Specially designed for better performance and higher productivity with fewer properties to reset resulting in cleaner code.">
        <title>Milligram | A minimalist CSS framework.</title>
        <link rel="icon" href="https://milligram.github.io/images/icon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>css/milligram.min.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>css/milligram.custom.css">
        <link rel="stylesheet" href="https://milligram.github.io/styles/main.css">
    </head>
    <body>

        <main class="wrapper">

            <nav class="navigation">
                <section class="container">
                    <a class="navigation-title" href="<?=BASE_URL?>">
                        <svg class="img" version="1.1" viewBox="0 0 463 669">
                            <g transform="translate(0.000000,669.000000) scale(0.100000,-0.100000)">
                                <path d="M2303 6677c-11-13-58-89-393-627-128-206-247-397-265-425-18-27-85-135-150-240-65-104-281-451-480-770-358-575-604-970-641-1032-10-18-45-74-76-126-47-78-106-194-107-212-1-3-11-26-24-53-60-118-132-406-157-623-19-158-8-491 20-649 82-462 291-872 619-1213 192-199 387-340 646-467 335-165 638-235 1020-235 382 0 685 70 1020 235 259 127 454 268 646 467 328 341 537 751 619 1213 28 158 39 491 20 649-25 217-97 505-157 623-13 27-23 50-23 53 0 16-57 127-107 210-32 52-67 110-77 128-37 62-283 457-641 1032-199 319-415 666-480 770-65 105-132 213-150 240-18 28-137 219-265 425-354 570-393 630-400 635-4 3-12-1-17-8zm138-904c118-191 654-1050 1214-1948 148-236 271-440 273-452 2-13 8-23 11-23 14 0 72-99 125-212 92-195 146-384 171-598 116-974-526-1884-1488-2110-868-205-1779 234-2173 1046-253 522-257 1124-10 1659 45 97 108 210 126 225 4 3 9 13 13 22 3 9 126 209 273 445 734 1176 1102 1766 1213 1946 67 108 124 197 126 197 2 0 59-89 126-197zM1080 3228c-75-17-114-67-190-243-91-212-128-368-137-580-34-772 497-1451 1254-1605 77-15 112-18 143-11 155 35 212 213 106 329-32 36-62 48-181 75-223 50-392 140-552 291-115 109-178 192-242 316-101 197-136 355-128 580 3 111 10 167 30 241 30 113 80 237 107 267 11 12 20 26 20 32 0 6 8 22 17 36 26 41 27 99 3 147-54 105-142 149-250 125z"></path>
                            </g>
                        </svg>
                         
                        <h1 class="title">Trongate Test</h1>
                    </a>
                    <ul class="navigation-list float-right">
                        <li class="navigation-item">
                            <a class="navigation-link" href="#popover-grid" data-popover>Menu</a>
                            <div class="popover" id="popover-grid">
                                <ul class="popover-list">
                                    <li class="popover-item">
									<?php 
									$item_url = anchor($modname.'/manage', true);					
									$attributes['class'] = 'popover-link';
									$attributes['title'] = 'Manage Records';
									echo anchor($item_url, 'Manage Records', $attributes);	
									?>
									</li>
                                    <li class="popover-item">
									<?php 
									$item_url = anchor($modname.'/create', true);					
									$attributes['class'] = 'popover-link';
									$attributes['title'] = 'Create New Record';
									echo anchor($item_url, 'Create Record', $attributes);	
									?>
									</li>
                                    <li class="popover-item">
									<?php 
									$item_url = anchor($modname.'/list', true);					
									$attributes['class'] = 'popover-link';
									$attributes['title'] = 'Browse Items';
									echo anchor($item_url, 'Browse Items', $attributes);	
									?>
									</li>								
									<!-- Next menu item goes here -->
                                </ul>
                            </div>
                        </li>
						<!-- Next menu goes here -->
                    </ul>
                </section>
            </nav>

            <?= Template::display($data) ?>

            <footer class="footer">
                <section class="container">
                    <p>Powered by <a target="_blank" href="https://trongate.io/" title="Trongate.">Trongate</a> by <a target="_blank" href="https://speedcodingacademy.com/" >David C.</a> Licensed under the <a target="_blank" href="https://opensource.org/licenses/MIT" title="MIT License">MIT License</a>.</p>
                </section>
            </footer>

        </main>

        <script src="https://milligram.github.io/scripts/main.js"></script>

    </body>
</html>