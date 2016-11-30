<!--    底部-->
<footer id="footer">
    <div class="bg-header">
        <a id="footer-logo" href="<?= $this->createUrl('site/index')?>" rel="home">
            <img src="<?= Yii::app()->request->baseUrl.'/static/images/bigdrop.svg'?>" alt="BigDropInc">
        </a>
        四川省 • 巴中市
    </div>
 <!--   <ul class="footer social">
        <li>
            <a target="_blank" href="http://www.facebook.com/bigdropcompany" class="fa fb"><span></span></a>
        </li><li><a target="_blank" href="http://twitter.com/bigdropinc" class="fa tw"></a></li>
        <li><a target="_blank" href="http://www.pinterest.com/bigdropinc" class="fa pt"></a></li>
        <li><a target="_blank" href="https://plus.google.com/+BigdropincCompany/posts?hl=en" class="fa gp"></a></li>
        <li><a target="_blank" href="http://www.instagram.com/bigdropinc" class="fa in"></a></li>
        <li><a target="_blank" href="https://www.behance.net/BigDropWebDesign" class="fa behance"></a></li>
    </ul>-->
    <div class="bd-footer">
       <a href="javascript:void (0)">Copyright 2015-2016 www.tiantianjianmian.top All rights reserved ©Realy_Cool@qq.com</a>
    </div>
</footer>
<div id="request_form" style="top: -100%; display: none;">
    <div class="close-button"><span class="fa"></span></div>
    <div class="form-wrap">
        <div class="title" style="top: 0px; opacity: 1;">Tell Us About <span>Your</span> Project</div>
        <div lang="en-US" dir="ltr">
            <form action="http://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8" method="POST" class="rq-form" id="rq-form" novalidate="">
                <input type="hidden" id="q_oid" class="oid" name="oid" value="">
                <input type="hidden" id="q_Location__c" class="Location__c" name="Location__c" value="">
                <input type="hidden" name="retURL" value="http://bigdropinc.com/thank-you/">
                <input type="hidden" name="lead_source" value="Request a Quote">
                <input type="hidden" name="Referral_URL__c" value="">
                <fieldset class="fieldset new-lead">
                    <div class="form-inline">
                        <div class="row">
                            <div class="small-12 medium-6 column">
                                <input id="q_full_name" maxlength="40" name="full_name" size="20" type="text" placeholder="Your Name" required="" data-parsley-id="6157"><ul class="parsley-errors-list" id="parsley-id-6157"></ul>
                                <input id="q_first_name" maxlength="40" name="first_name" size="20" type="hidden">
                                <input id="q_last_name" maxlength="80" name="last_name" size="20" type="hidden">
                                <input id="q_email" maxlength="80" name="email" size="20" type="text" placeholder="Email Address" required="" data-parsley-id="9912"><ul class="parsley-errors-list" id="parsley-id-9912"></ul>
                                <input id="q_phone" maxlength="40" name="phone" size="20" type="text" placeholder="Phone Number" required="" data-parsley-id="9502"><ul class="parsley-errors-list" id="parsley-id-9502"></ul>

                            </div>
                            <div class="small-12 medium-6 column">
                                <textarea id="q_description" name="description" cols="30" rows="6" placeholder="Project Brief" required="" data-parsley-id="1670"></textarea><ul class="parsley-errors-list" id="parsley-id-1670"></ul>

                            </div>
                        </div>
                    </div>

                </fieldset>
                <div class="text-center">
                    <input id="q_conactSubmit" type="submit" name="submit" onclick="myFunction1()">
                </div>
        </div>
    </div>
</div>