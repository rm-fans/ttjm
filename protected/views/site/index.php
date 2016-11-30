<!--    内容部分-->
<div id="content" class="home-page-content">
        <ul id="navi">
            <li><a href="#slider" class="active"></a></li>
            <li><a href="#trends"></a></li>
            <li><a href="#identity"></a></li>
            <li><a href="#personal"></a></li>
            <li><a href="#style"></a></li>
        </ul>
        <section id="slider" class="side side-1" style="height: 910px;">
            <div id="home-slider-wrap" class="home-slider" style="height: 910px;">
                <div class="item about" style="height: 910px; background-image: url(<?= Yii::app()->request->baseUrl.'/static/images/index-1.jpg'?>);">
                    <div class="item-wrap" style="height: 910px;">
                        <div class="item-text-wrap" style="margin-top: -108px; top: 50%;">
                            <h1 class="title" style="top: 0px; opacity: 2;">天 天 见 <span> 面</span></h1>
                            <div class="title" style="top: 0px; opacity: 1;">Very Welcome TO<span> Enter</span></div>
                            <a href="javascript:void(0);" class="bd-button" style="top: 0px; opacity: 1;">view overall<span class="hover" style="opacity: 0;">view overall</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <a id="subnav" href="<?= $this->createUrl('site/index')?>#trends" class="trigger"><img src="<?= Yii::app()->request->baseUrl.'/static/images/scroll1.png'?>" alt="scroll"></a>
        </section>
<!--        干馏系列-->
        <section id="trends" class="side side-2" style="height: 910px;">
            <div class="item-wrap" style="height: 910px; background: url(<?= Yii::app()->request->baseUrl.'/static/images/home/pattern.png'?>);">
                <div class="item-text" style="height: 910px; margin-top: -384px;">
                    <div class="text" style="top: 0px; opacity: 1;">干 馏 系 列<br><span class="black">Exquisite</span></div>
                    <div class="picture">
                        <img class="pic animated flipInX" src="<?= Yii::app()->request->baseUrl.'/static/images/trends.png'?>" alt="Web Design Company" width="605" height="430" style="opacity: 0;">
                    </div>
                </div>
            </div>
        </section>
<!--       汤面系列-->
        <section id="identity" class="side side-3" style="height: 910px;">
            <div class="item-wrap" style="height: 910px; background: url(&quot;<?= Yii::app()->request->baseUrl.'/static/images/home/pattern.png'?>&quot;);">
                <div class="item-text" style="height: 910px; margin-top: -384px;">
                    <div class="text" style="top: 0px; opacity: 1;">汤 面 系 列<br><span class="black">Dainty</span></div>
                    <div class="picture">
                        <img class="pic animated rubberBand" src="<?= Yii::app()->request->baseUrl.'/static/images/identity.png'?>" alt="Website Development Firm" width="487" height="310" style="opacity: 0;">
                    </div>
                </div>
            </div>
        </section>
<!--       抄手系列-->
        <section id="personal" class="side side-4" style="height: 910px;">
            <div class="item-wrap" style="height: 910px; background: url(&quot;<?= Yii::app()->request->baseUrl.'/static/images/home/pattern.png'?>&quot;);">
                <div class="item-text" style="height: 910px; margin-top: -384px;">
                    <div class="text" style="top: 0px; opacity: 1;">抄 手 系 列<br><span class="black">Inviting</span></div>
                    <div class="picture">
                        <img class="pic animated rollIn" src="<?= Yii::app()->request->baseUrl.'/static/images/personal.png'?>" alt="Web Design Agency" width="477" height="402" style="opacity: 0;">
                    </div>
                </div>
            </div>
        </section>
<!--       特色小吃-->
        <section id="style" class="side side-5" style="height: 910px;">
            <div class="item-wrap" style="height: 910px; background: url(&quot;<?= Yii::app()->request->baseUrl.'/static/images/home/pattern.png'?>&quot;);">
                <div class="item-text" style="height: 910px; margin-top: -384px;">
                    <div class="text" style="top: 0px; opacity: 1;">特 色 小 吃<br>My <span class="black">Style</span></div>
                    <div class="picture">
                        <img class="pic animated" src="<?= Yii::app()->request->baseUrl.'/static/images/style.png'?>" alt="Web Design New York" width="318" height="525" style="opacity: 0;">
                    </div>
                </div>
            </div>
        </section>
</div>