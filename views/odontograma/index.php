<?php require('views/navbar.php'); ?>
<link rel="stylesheet" href="<?php css('odontograma'); ?>">
<div class="grid-container fluid">
    <div class="grid-x">
        <div class="cell text-center">
            <h2>Odontograma de: <?php echo @$this->data['nombre'] . ' ' . @$this->data['apellido'] ?></h2>
            <input type="hidden" id="idcliente" class="idcliente" value="<?php echo @$this->data['idcliente']; ?>">
        </div>
        <div class="cell grid-x">
            <div class="cell large-6">
                <div class="arcada-superior cell large-6">
                    <svg viewBox="0 0 501 458">
                        <image href="<?php image('superior1.png') ?>" x="0" y="0" />
                        <g fill="transparent">
                            <polygon class="btn-pieza" data-pieza="18"
                                points="37,425 35,417 35,410 32,403 28,394 30,389 31,384 36,376 40,373 47,371 55,372 62,374 67,375 74,377 82,378 89,380 97,382 103,384 110,389 111,396 111,404 110,411 106,418 105,425 98,430 90,432 82,435 74,438 66,432 57,432 49,434 41,431"
                                title="1.8" />
                            <polygon class="btn-pieza" data-pieza="17"
                                points="39,365 45,366 50,368 56,369 63,371 70,373 77,376 89,376 94,374 100,371 104,364 106,356 107,349 106,339 107,331 103,323 98,315 91,310 83,310 74,309 67,306 60,303 53,298 45,298 38,301 32,304 29,310 27,316 27,322 28,333 27,346 30,354 31,360"
                                title="1.7" />
                            <polygon class="btn-pieza" data-pieza="16"
                                points="50,292 42,289 37,283 33,275 33,266 35,258 35,250 33,241 37,233 42,227 50,222 55,219 62,219 67,219 72,222 78,224 85,226 91,228 97,232 101,238 106,241 110,247 114,257 112,267 107,273 107,279 107,286 105,296 99,299 94,302 88,304 80,304 70,304 61,300 55,297 52,294"
                                title="1.6" />
                            <polygon class="btn-pieza" data-pieza="15"
                                points="70,218 64,215 56,214 50,208 47,199 47,191 49,181 52,176 57,174 60,165 65,162 70,162 75,165 80,168 86,168 93,169 100,173 104,179 109,183 113,190 113,198 111,205 107,211 103,218 97,220 87,222 78,220"
                                title="1.5" />
                            <polygon class="btn-pieza" data-pieza="14"
                                points="77,162 70,157 65,150 65,142 67,133 70,126 76,123 82,119 87,115 92,113 98,114 102,119 108,123 113,126 121,128 125,133 127,140 128,148 125,155 120,162 114,167 107,167 98,167 89,164"
                                title="1.4" />
                            <polygon class="btn-pieza" data-pieza="13"
                                points="110,119 103,114 100,108 99,99 102,91 102,84 105,77 110,74 117,71 123,67 128,67 134,69 140,76 142,84 146,91 148,99 148,106 147,115 145,121 138,126 130,125 121,125 115,122"
                                title="1.3" />
                            <polygon class="btn-pieza" data-pieza="12"
                                points="142,76 137,68 135,61 137,54 140,46 148,38 157,35 166,30 175,25 181,28 184,36 187,42 190,49 190,57 191,64 190,72 187,80 182,88 174,89 164,87 154,83"
                                title="1.2" />
                            <polygon class="btn-pieza" data-pieza="11"
                                points="191,50 182,29 185,21 192,18 197,15 215,9 222,8 244,9 249,14 248,27 244,39 235,52 230,65 222,72 213,75 202,69 196,61"
                                title="1.1" />
                            <polygon class="btn-pieza" data-pieza="21"
                                points="250,26 250,14 255,9 281,9 299,15 310,19 318,31 312,44 307,55 297,68 289,75 277,76 267,68"
                                title="2.1" />
                            <polygon class="btn-pieza" data-pieza="22"
                                points="310,51 318,32 327,29 352,39 362,56 364,64 359,74 354,82 345,86 330,95 320,95 312,89 310,75 309,63"
                                title="2.2" />
                            <polygon class="btn-pieza" data-pieza="23"
                                points="355,81 361,74 367,70 375,70 385,76 393,82 395,88 397,95 399,106 398,115 392,121 385,126 377,131 365,129 350,127 346,119 347,106 349,95"
                                title="2.3" />
                            <polygon class="btn-pieza" data-pieza="24"
                                points="377,132 401,117 407,119 412,123 420,126 427,133 429,141 430,150 429,159 424,165 412,170 402,174 394,176 383,177 374,172 367,162 365,150 368,140"
                                title="2.4" />
                            <polygon class="btn-pieza" data-pieza="25"
                                points="395,178 407,175 422,167 435,168 440,175 445,184 448,193 447,201 447,209 442,216 432,222 421,225 408,225 397,225 385,218 380,208 378,196 384,186"
                                title="2.5" />
                            <polygon class="btn-pieza" data-pieza="26"
                                points="405,228 415,226 427,226 437,223 445,226 448,231 454,233 457,242 460,249 459,256 457,266 459,273 457,283 454,291 445,296 438,301 428,305 420,308 408,311 397,310 386,303 382,291 380,277 378,262 382,248 392,236"
                                title="2.6" />
                            <polygon class="btn-pieza" data-pieza="27"
                                points="398,318 410,316 420,311 428,307 440,305 450,305 455,310 460,317 463,325 462,333 460,343 461,351 457,360 455,368 449,373 442,375 434,375 425,377 417,381 407,383 398,382 387,377 383,368 382,355 382,345 384,335 388,323"
                                title="2.7" />
                            <polygon class="btn-pieza" data-pieza="28"
                                points="398,383 406,384 412,383 420,380 428,377 436,376 443,377 450,379 458,384 461,392 464,399 460,407 457,414 457,420 455,429 450,435 441,439 432,440 424,439 417,441 410,441 403,439 397,436 390,434 383,430 379,420 377,412 375,404 377,394 382,387 389,383"
                                title="2.8" />
                        </g>
                    </svg>
                </div>
            </div>
            <div class="cell large-6">
                <div class="arcada-inferior cell large-6">
                    <svg viewBox="0 0 550 460">
                        <image href="<?php image('inferior1.png') ?>" x="0" y="0" />
                        <g fill="transparent">
                            <polygon class="btn-pieza" data-pieza="48"
                                points="104,110 95,112 85,111 77,109 68,102 60,93 56,84 54,74 55,66 60,58 63,49 67,43 72,36 80,32 87,30 97,29 108,32 115,39 120,44 125,47 129,55 129,61 129,69 129,76 128,83 129,89 127,101 120,106 112,107 108,108"
                                title="4.8">
                                <title>4.8</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="47"
                                points="87,113 94,114 100,111 107,111 113,109 120,112 126,114 132,118 136,123 138,128 139,133 140,141 140,146 140,151 140,159 142,164 142,170 140,176 136,181 132,184 125,186 116,188 111,188 105,190 99,191 92,189 84,183 75,177 67,167 65,156 64,146 66,136 70,127 76,120 82,116"
                                title="4.7">
                                <title>4.7</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="46"
                                points="93,198 99,195 105,192 112,190 119,190 125,190 133,192 140,196 146,200 150,208 154,213 155,220 153,229 155,235 157,243 157,250 155,256 150,260 145,263 140,266 134,268 128,270 122,273 116,273 110,272 104,268 99,264 92,260 88,253 87,245 82,238 80,230 82,220 85,211 87,204"
                                title="4.6">
                                <title>4.6</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="45"
                                points="125,276 130,271 136,271 143,270 150,271 157,274 161,283 161,293 161,301 160,307 155,312 151,317 145,320 139,322 133,322 127,320 120,316 114,310 112,303 113,294 114,286 118,279"
                                title="4.5">
                                <title>4.5</title>
                            </polygon>
                            <polygon
                                points="147,321 154,320 160,319 167,319 173,321 178,328 178,338 178,346 178,356 172,363 165,370 157,368 151,363 143,359 139,353 135,345 136,335 140,326 144,323"
                                title="4.4">
                                <title>4.4</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="43"
                                points="167,369 181,358 190,354 199,356 204,363 204,369 205,377 205,384 201,394 198,400 192,404 186,405 179,401 172,395 167,388 165,378"
                                title="4.3">
                                <title>4.3</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="42"
                                points="197,409 202,395 208,389 215,381 225,377 230,380 232,387 237,396 238,414 235,424 234,433 225,432 218,429 211,426 202,419"
                                title="4.2">
                                <title>4.2</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="41"
                                points="235,432 237,423 241,414 247,401 252,391 260,389 266,396 269,406 273,424 274,432 272,436 262,441 251,440 241,437"
                                title="4.1">
                                <title>4.1</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="31"
                                points="275,431 275,421 277,411 280,398 282,392 289,391 295,391 298,401 302,409 310,418 312,429 310,436 302,438 295,440 289,440 282,440 277,436"
                                title="3.1">
                                <title>3.1</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="32"
                                points="313,432 310,415 311,407 312,400 316,395 317,386 323,378 330,378 334,383 340,389 346,393 352,405 350,413 345,419 339,424 333,428 325,432"
                                title="3.2">
                                <title>3.2</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="33"
                                points="353,407 347,391 343,382 343,374 343,363 347,355 358,351 365,357 371,360 380,370 384,379 381,387 380,392 375,397 369,402 362,405 356,407"
                                title="3.3">
                                <title>3.3</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="34"
                                points="382,368 377,363 371,357 369,350 369,341 368,331 373,323 380,320 386,319 392,319 401,320 406,327 412,334 411,342 410,348 409,354 402,359 398,364 391,366"
                                title="3.4">
                                <title>3.4</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="35"
                                points="411,322 402,319 396,316 392,310 387,306 385,297 385,290 387,282 390,277 396,272 403,270 409,270 416,270 424,275 428,280 433,285 436,292 436,300 435,307 430,313 422,320"
                                title="3.5">
                                <title>3.5</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="36"
                                points="439,272 431,273 424,273 415,268 407,265 401,262 395,258 390,249 390,241 392,235 395,230 392,223 392,215 394,208 400,203 405,198 414,193 424,189 430,189 436,190 443,190 448,193 453,195 457,202 461,208 464,216 466,225 465,235 460,245 458,253 455,260 447,265"
                                title="3.6">
                                <title>3.6</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="37"
                                points="455,189 447,190 439,188 430,187 423,185 417,185 411,181 407,175 405,166 407,158 408,151 409,144 409,134 410,127 415,122 423,117 430,114 439,112 447,113 455,114 461,117 468,122 474,127 477,134 480,144 480,149 477,154 476,159 477,166 474,172 469,178 463,183"
                                title="3.7">
                                <title>3.7</title>
                            </polygon>
                            <polygon class="btn-pieza" data-pieza="38"
                                points="460,110 452,109 443,108 435,107 428,104 422,97 420,91 420,84 420,75 419,68 420,57 421,51 425,46 432,39 437,34 444,34 452,31 458,30 466,31 472,34 479,42 483,49 488,57 491,70 491,80 491,88 486,93 482,99 475,105 468,109"
                                title="3.8">
                                <title>3.8</title>
                            </polygon>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-x grid-margin-x margin-top-2 info-diente-seleccionado" id="info-diente">
        <div class="cell large-5">
            <div class="grid-x cell text-center">
                <div class="cell large-4 text-left">
                    <span class="lead">Diente: </span><strong class="diente-seleccionado"
                        id="diente-seleccionado">0.0</strong>
                    <input type="hidden" name="diente" id="diente-input">
                </div>
                <div class="cell large-8">
                    <select name="procedimientos-select" id="procedimientos-select"
                        class="procedimientos-select"></select>
                </div>
            </div>
            <div class="cell grid-x grid-margin-x">
                <div class="cell large-6">
                    <div class="cell callout">
                        Imagen representativa del diente
                    </div>
                </div>
                <div class="cell large-6">
                    <div class="cell box-img" id="box-img">
                        <img id="imagen-pieza" src="" alt="Sin imagen subida">
                    </div>
                    <div class="cell file-upload">
                        <label for="file" class="file-label">📂 Subir Imagen</label>
                        <input type="file" name="file" id="file" accept="image/*">
                        <div class="file-name" id="file-name">Ningun Archivo Seleccionado</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cell large-7 grid-x grid-margin-x">
            <div class="cell">
                <h4>Observaciones: </h4>
                <textarea name="observaciones" id="observaciones" class="observaciones"></textarea>
            </div>
            <div class="cell grid-x">
                <div class="cell large-6">
                    <select name="estado" id="estado">
                        <option value="1">ZOE</option>
                        <option value="2">DICAL+IONOMERO</option>
                        <option value="3">DIR</option>
                    </select>
                </div>
                <div class="cell large-6">
                    <select name="condicion" id="condicion">
                        <option value="1">Sano</option>
                        <option value="2">Cariado</option>
                        <option value="3">Ausente</option>
                    </select>
                </div>
            </div>
            <div class="cell text-right">
                <button class="button btn-success" id="guardar">Guardar Todo</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php js('odontograma'); ?>"></script>
<?php require('views/footer.php'); ?>