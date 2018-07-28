@extends("master")
@section("content")
<!--Start of Feature Product-->
      <section class="single section-padding">
         <div class="container">
            <!--End of row-->
            <div class="row">               
               <div class="col-sm-8">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title">Email This Poster</h3>
                     </div>
                     <div class="panel-body">
                        <div class="panel-info-box">
                           <i class="fa fa-exclamation-circle"></i>
                           <p>If the seller cannot or will not meet you in person, be suspicious. Never send money in advance. Always inspect and/or test the item fully before paying for it. If it can't be inspected or tested before the sale, just say "no." </p>
                        </div>
                        <a href="" class="more-advice pull-right">More buying advice...</a>

                        <form action="{{url('/')}}/email-user/{{$sel->id}}" method="post">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$sel->id}}" />
                           <div class="email-box">
                              <div class="email-box-left">
                                 <label><span class="star">*</span> Your Email:</label>
                              </div>
                              <div class="email-box-right">
                                 <input type="email" name="email" class="form-control" />
                                 <small>(your email address will be shown to the seller, don't repeat it below)</small>
                              </div>
                           </div>
                           <div class="email-box">
                              <div class="email-box-left">
                                 <label><span class="star">*</span> Subject:</label>
                              </div>
                              <div class="email-box-right">
                                 <b>hockeygearshop.com: Buyers Question - {{$sel->title}}!</b>
                              </div>
                           </div>
                           <div class="email-box">
                              <div class="email-box-left">
                                 <label><span class="star">*</span> Message</label>
                              </div>
                              <div class="email-box-right">
                                 <textarea name="msg" class="form-control"></textarea>
                              </div>
                           </div>
                           <div class="email-box">
                              <div class="email-box-left">
                                 &nbsp;
                              </div>
                              <div class="email-box-right">
                                 <input type="submit" name="sub" value="Send" class="btn btn-success" />
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title">Frequently Asked Questions</h3>
                     </div>
                     <div class="panel-body" style="padding: 0;">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-bottom: 0">
                           <div class="panel panel-info faq">
                              <div class="panel-heading" role="tab" id="headingOne">
                                 <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                       What are the guidelines for buying an item?
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                 <div class="panel-body">
                                    We suggest that you meet with the seller in person, so you can thoroughly inspect the item (including the working condition). If you are unable to do so, for any reason, we suggest that you do not make the purchase.
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-info faq">
                              <div class="panel-heading" role="tab" id="headingTwo">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                       How do I know if this ad is a scam?
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                 <div class="panel-body">
                                   Extremely undervalued items and/or a seller who refuses to deal with you in person, should be considered a red flag.
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-info faq">
                              <div class="panel-heading" role="tab" id="headingThree">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                       How do I warn others if an ad is a scam?
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                 <div class="panel-body">
                                    The best way to deal with a possible scam is to report the ad to our moderators. To do this, open the ad and click on the <b>Report Ad</b> indicator.
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-info faq">
                              <div class="panel-heading" role="tab" id="headingFour">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                       What should I do if the seller is not answering my questions?
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                 <div class="panel-body">
                                    First, we suggest that you check your spam and deleted folders in the event that their emails are being redirected. Failing this, you may want to try using another email address or contact us.
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-info faq">
                              <div class="panel-heading" role="tab" id="headingFive">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                       Should I send or receive money for items afar?
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                 <div class="panel-body">
                                    NO. Nope. Never. Unless you can see the palm of the hand of the person taking your money, it is probably a scam. Always conduct your transactions in person.
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-info faq">
                              <div class="panel-heading" role="tab" id="headingSix">
                                 <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                       When should I give out the location address for someone to view my item?
                                    </a>
                                 </h4>
                              </div>
                              <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                 <div class="panel-body">
                                    It is best to not hold your items except for the amount of time it takes for a potential buyer to drive to the location of the item. Have the potential buyer call you just prior to leaving to make certain the item is still available and provide them with the address at this time.
                                 </div>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--End of row-->
         </div>
         <!--End of container-->
      </section>
      <!--end of Feature Product-->
      @endsection