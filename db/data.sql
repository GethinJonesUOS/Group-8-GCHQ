INSERT INTO tooltips (hint_id, text) VALUES (1, '<h3>Suspicious URLs</h3><p>Phishing emails often want you to visit a website where you will be asked to enter your login details. After entering your login detail you won''t have logged in and the frausters will have your login details.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (2, '<h3>Misspelled Words</h3><p>While it is easy for any one to make a typo while writing an email, misspelled words are often the hallmark of scammers and fraudsters.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (3, '<h3>Company logo</h3><p>The appearance of a company logo certainly seems to add legitimacy to any communications received purporting to be from a business, however, these logos are easily scraped from corporate websites and inserted into emails in order to add weight to their claims.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (4, '<h3>Legitimate URLs</h3><p>Fraudsters will sometimes include links to real pages from the companies they purport to be from in order to provide confidence that the email is legitimate.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (5, '<h3>Generic Names</h3><p>Any organisation that you have registered with should have your full name and will use it to address you in emails. However be wary of more sophisticated attacks where the fraudsters have been able to obtain your name already.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (6, '<h3>Real Names</h3><p>Having your real name in the email may provide some substance to its legitimacy but, be aware that you  may be falling victim to a more targeted attack where fraudsters have illegally obtained your basic details or from social media sites.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (10, '<h3>txt files</h3><p>Text files with the extension .txt are generally quite harmless as their only purpose is for storing and transmitting human readable text.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (11, '<h3>Microsoft Office Files</h3><p>MS Office files such as though for those used for spreadsheets, word processing and presentations are common place in many business and personal settings. However, Office files can store executable code, known as macros.</p><p>before opening an MS Office files be sure you know where the file originated from and don''t be tempted by enticing file names.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (12, '<h3>Program Information Files</h3><p>Files with the extension .pif can contain code that can be executed by Windows. Viruses have been created in the .pif format that locate and transmit personal files to fraudsters.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (13, '<h3>Executables</h3><p>Files with the file extension .exe contain code that is executed by the windows operating system and are essential for the system to operate. A common trick to get people to run files with malicious code is to include a file extension that is know to be safe before the actual .exe extension</p>');
INSERT INTO tooltips (hint_id, text) VALUES (14, '<h3>Unprotected Personal Information</h3><p>While .txt files are considered to be safe from malicious code, they offer no protection from people who gain illegal access to your files. There are many software solutions available that offer password protected vaults for securely storing sensitive information.</p>');
INSERT INTO tooltips (hint_id, text) VALUES (15, '<h3>Image Files</h3><p>Image files such as bmp, gif, jpg and png are safe to keep around and open. Just be sure they are actually image files before opening them and not some malicious code waiting for somebody to run it.</p>');

INSERT INTO emails (id, `from`, from_name, subject, body, isPhishing) VALUES (2, 'messager-amazon-noreplis.ua', 'Amazon', 'URGENT - TRASACTION ON HOLD', '<img hint hint-id="3" src="images/emails/amazonheader.png" width="250" height="35">
<hr/>
<p>We have placed a hold on your account for <span hint hint-id="2">pendig</span> orders and all transactions.</p>
<p>This is due to an issue from your card holding company.</br>
Please get into contact with your bank holder or resolve this issue <span hint url="www.aamaz&oacute;ne.br" hint-id="1">via our web service.</span></p>
<hr/>
<span hint url="www.aamaz&oacute;ne.br" hint-id="1"><button>Click here to recover your account</button></span></br>
<hr/>
<small>This email was sent from a notification-only email address that cannot accept incoming email. Please do not reply to this message.
&copy; 2021 Amazon.com, Inc. or its affiliates.
<br/> All rights reserved.
<br/> Amazon, Amazon.com, and the Amazon.com logo are registered trademarks of Amazon.com, Inc. or its affiliates.
<br/> Amazon.com, 410 Terry Avenue N., Seattle, WA 98109-5210</small>
', 1);
INSERT INTO emails (id, `from`, from_name, subject, body, isPhishing) VALUES (3, 'eBaey-supporter.de@supportholder.bayegg.com', 'eBay', 'Fraudulent Transaction', '<img hint hint-id="3" src="images/emails/ebayheader.png" width="250" height="75">
<hr/>
<h2><b>Fraudulent <span hint hint-id="2">Transactione</span></b></h2>
<p>We regret to <span hint hint-id="2">informe</span> you that your eBay account has been used for <span hint hint-id="2">fradulant</span> transaction.</p>
<p>Your eBay account has been temporarily <span hint hint-id="1">suspendeded</span> pending further more investigations.</p>
<p>In order to continune using your eBay account, and to prevent further charges added to your account - you must update your billing information.</p>
<p>If you wish for your account to remain active, then <span hint url="www.Ebayinfo-billing.an" hint-id="1">update your billing information now.</span></p>
<p>Best Regards,<br/> eBay Fraud Protection Team.</p>
<hr/>
<h3>For more details on the transactions in question, please visit <span hint url="www.Ebayinfo-billing.an" hint-id="1">your accounts page</span> or contact us on +376-355-5991-753</h3>
<hr/>
<small>Copyright &copy; 1995-2021 eBay Inc.
<br/>California, San Hose, USA.
<br/>All Rights Reserved.</small>', 1);
INSERT INTO emails (id, `from`, from_name, subject, body, isPhishing) VALUES (4, 'MicrousofteAccountTieam.fr@lecheznantes.com', 'Microsoft Accounts', 'Security Alert - Important', '<h1>Security Alert - Important</h1>
<hr>
<p>We think that someone else might have access to your Microsoft account.<br/>
<p>You are now required to verify your identity and <span hint url="www.password-micrasoftchange.br" hint-id="1">change your password.</span></p>
<p>If someone else has access to your account, they may have your password and might be trying to access your personal information.</p>
<P>If you haven''t already recovered your account, we can help you do it now.</p>
<span hint url="password-micrasoftchange.br" hint-id="1"><button>Recover Account</button></span>
<hr/>
<p>Thanks,<br>
The Microsoft account team</p>
<hr/>
<h3>For further detailed instructions on how to unlock your account, please visit your accounts page or contact us on +91-935-5598-125
<p>Learn how to make your <span hint url="www.microsoft.com" hint-id="1">account more secure.</span></p>', 1);
INSERT INTO emails (id, `from`, from_name, subject, body, isPhishing) VALUES (5, 'securepayments.Paypalclient.2021@securitiAssurance.paypall.com', 'PayPal', 'You have funds in your account', '<h1>You have funds in your account</h1>
<hr>
<p>Dear <span hint hint-id="5">Client</span>,</p>
<p>You have funds in your account,<br/>
<p>Please <span hint url="paypoe-il4312.kr" hint-id="1">login and confirm your recipient details</span> to receive the lump sum.</p>
<p>If you do not confim your details then you will not receive the funds and will still be charged with a transaction fee (5%)</p>

<hr/>
<p>Thanks,<br> Paypal</p>
<hr/>
<img hint hint-id="3" src="images/emails/paypalheader.png" width="350" height="75">
<hr/>
<small>Not sure why you received this email? Learn more
How do I know this is not a Spoof email?

Spoof or ‘phishing'' emails tend to have generic greetings such as "Dear PayPal member". Emails from PayPal will always contain your full name.

Find out more <span hint url="paypal.com" hint-id="4">here.</span>

Copyright © 1999-2020 PayPal.
<br/> All rights reserved.
<br/> PayPal (Europe) S.à r.l. et Cie, S.C.A., Société en Commandite par Actions.
<br/>Registered office: 22-24 Boulevard Royal, L-2449, Luxembourg, R.C.S. Luxembourg B 118 349.
<br/>26023 76832</small>
<hr/>', 1);
INSERT INTO emails (id, `from`, from_name, subject, body, isPhishing) VALUES (6, 'covid19supportfunds@4ijnndm.net', 'UK Government', 'CRITICAL UK RESIDENTIAL CORONAVIRUS SUPPORT FUND UPDATE', '<h2><u>URGENT UK RESIDENTIAL CORONAVIRUS SUPPORT FUND UPDATE</u></h2>
<hr>
<img hint hint-id="3" src="images/emails/govukbanner.png" width="450" height="130">
<hr>
<h3><b>The government has taken many urgent steps to overcome the coronavirus(COVID-19) both physically, and economically.</b></h3>
<p>This is why we are extending our warmest wishes and greatest steps towards defeating the virus yet.
<br/> With the virus vaccine being distributed amongst the most vulnerable, it is imperitive that we act now - and save our economy.
<br/>For this reason alone, we have launched the <span hint hint-id="1" url="refundcovidreturn.sijdwa144.net">Coronavirus Refund Plan</span> - where we are giving every key member of each household the sum of £7540.
<p>The funds can be used to protect yourself and your family against COVID-19 <br/>
<span hint hint-id="4">(https://www.nhs.uk/conditions/coronavirus-covid-19-funding/)</span> by not going outside unless absolutely essential.</p>
<hr>
<p><b>Secretary of State for Health and Social Care, <br/> The Rt Hon. Matt Hancock MP.</b></p>
<hr>
<hr>
<img hint hint-id="3" src="images/emails/covid19footer.png" width="700" height="100">
<hr>', 1);
INSERT INTO emails (id, `from`, from_name, subject, body, isPhishing) VALUES (7, 'surveys@mailer.netflix.com', 'Netflix', 'Netflix values your opinion', '<hr/>
<h1>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img hint hint-id="3" src="images/emails/netflix.png" width="145" >
</h1>
</hr>
<p><td class="x_content-shell" bgcolor="rgb(51, 51, 51)"
background-position: initial;
background-size: initial;
background-attachment: initial;
background-origin: initial;
background-clip: initial;
background-repeat: no-repeat;
background-color: rgb(51, 51, 51) !important;"
data-ogsb="rgb(255, 255, 255)"
data-ogab="#ffffff">
<table class="x_content" width="100%" cellpadding="0" cellspacing="0" border="0"><tbody><tr><td class="x_logo" align="center" style="padding:46px 0 0 0">
<a href="https://www.netflix.com/browse"></a>
</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td class="x_headline" style="font-family: Helvetica, Arial, sans; font-weight: bold; font-size: 32px;
color: rgb(0,0,0) !important; line-height: 36px; padding: 40px 90px 10px;" data-ogsc="rgb(34, 31, 31)"><span data-markjs="true" class="marktiyrm7mmi" data-ogac="" data-ogab="" data-ogsc="" data-ogsb="" color: black;" >Netflix values your opinion </td></tr><tr>
 <td class="x_copy" style="padding:22px 90px 0 90px;
 font-family:Helvetica Neue,Helvetica,Roboto,Segoe UI,sans-serif;
 font-size:18px; line-height:24px">Hello, <span hint hint-id="6"><<forename>></span></td></tr><tr>
 <td class="x_copy" style="padding:22px 90px 0 90px;
 font-family:Helvetica Neue,Helvetica,Roboto,Segoe UI,sans-serif; font-size:18px; line-height:24px">Help us shape the <span data-markjs="true" class="marktiyrm7mmi" data-ogac="" data-ogab="" data-ogsc="" data-ogsb="" style="background-color: rgb(255, 255, 255);
 color: black;">Netflix</span> experience by taking this survey. Your feedback is very important to us, so we hope you can spare some time to complete it. </td></tr><tr>
 <td class="x_button-shell" style="padding:22px 90px 0 90px">
 <table class="x_button x_red" cellpadding="0" cellspacing="0" border="0"><tbody><tr>
 <td style="color:rgb(255,255,255); background-color:rgb(229,9,20);
 padding:10px 16px;
 max-width:252px;
 border-radius:2px">
 <span hint hint-id="4" url="https://www.netflix.com/browse" style="color:inherit;
 color:rgb(255,255,255);
 font-size:16px;
 line-height:24px;
 font-weight:normal;
 text-align:center;
 text-decoration:none;
 font-family:Helvetica Neue,Helvetica,Roboto,Segoe UI,sans-serif; letter-spacing:0.025em">BEGIN</span>
 </td></tr></tbody></table></td></tr><tr><td class="x_copy" style="padding:22px 90px 0 90px;
 font-family:Helvetica Neue,Helvetica,Roboto,Segoe UI,sans-serif;
 font-size:18px;
 line-height:24px">We appreciate your time and feedback! </td></tr><tr>
 <td class="x_copy" style="padding:22px 90px 0 90px;
 font-family:Helvetica Neue,Helvetica,Roboto,Segoe UI,sans-serif;
 font-size:18px;
 line-height:24px">-Your friends at <span data-markjs="true" class="marktiyrm7mmi" data-ogac="" data-ogab="" data-ogsc="" data-ogsb="" style="background-color: rgb(255, 255, 255);
 color: black;">Netflix
 <hr/>
 <small>
<p>Questions? Please call 0800 096 6379.

As a Netflix member or a former member, we will occasionally send you emails of this nature. You can learn about our customer surveys <span hint hint-id="4" url="www.netflix.com">here.</span></p>
<p>Please do not reply to this email. As we are unable to respond from this email address. If you need help or would like to contact us, please visit our help centre.<br/>

Usage of the Netflix service and website is subject to our Terms of Use and Privacy Statement at www.netflix.com.

</small>
</span> </td></tr><tr><td class="x_escape-hatch-neutral-shell" style="padding:30px 90px 0 90px">
 <table class="x_escape-hatch-neutral-table" width="100%" cellpadding="0" cellspacing="0" border="0"><tbody><tr>
 <td class="x_escape-hatch-neutral x_text" style="font-family:Helvetica Neue,Helvetica,Roboto,Segoe UI,sans-serif;
 font-size:15px; line-height:17px; font-weight:bold; padding:17px 0 0 0; vertical-align:bottom; text-decoration:none">&nbsp;
 </td></tr></tbody></table></td></tr></tbody></table></td>

<hr/>', 0);
INSERT INTO emails (id, `from`, from_name, subject, body, isPhishing) VALUES (8, 'webmaster@slc.co.uk', 'SFE', 'Making sure your payment arrives', '<img src="images/emails/studentfinanceengland.png" width="650" height="100"<br/>
<hr/>

<p>Customer Reference Number:(SOME RANDOM 11 DIGIT VALUE HERE E.G.(94657393542))</p>
<p>Hi (NAME HERE),</p>
<p class="x_content" style="font-size: 16px; color: rgb(0, 0, 0) !important;" data-ogsc="">As you&apos;re nearing the end of your first term, we know you&apos;ll be looking ahead to next term, and your next student finance payment.</p>
<p class="x_content" style="font-size: 16px; color: rgb(0, 0, 0) !important;" data-ogsc="">We understand some universities are encouraging a staggered return after the winter break. This will not affect your payment date. </p>
<p class="x_content" style="font-size: 16px; color: rgb(0, 0, 0) !important;" data-ogsc="">Your next payment is due on <b>11 January</b>. To check your payment amount, go to the &apos;Your finance&apos; section of your <a href="https://www.gov.uk/student-finance-register-login" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="font-size: 16px; color: rgb(102, 195, 101) !important;" data-ogsc="">online account</a>.</p>
<hr/>
<h2 class="x_subtitle" style="color: rgb(0, 0, 0) !important; font-size: 16px;" data-ogsc="rgb(0, 0, 0)">When you&apos;ll get paid</h2>
<p class="x_content" style="font-size: 16px; color: rgb(0, 0, 0) !important;" data-ogsc="">We&apos;ll send you a text message a few days before you receive your payment to let you know it&apos;s on its way. </p>
<hr/>
<h2 class="x_subtitle" style="color: rgb(0, 0, 0) !important; font-size: 16px;" data-ogsc="rgb(0, 0, 0)">If your details have changed</h2>
<p class="x_content" style="font-size: 16px; color: rgb(0, 0, 0) !important;" data-ogsc="">Make sure we&apos;ve got all your correct details. Go to your <a href="https://www.gov.uk/student-finance-register-login" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="font-size: 16px; color: rgb(102, 195, 101) !important;" data-ogsc="">online account</a> to update your: <ul><li>mobile number</li><li>bank deatils(last changes to be made by <b>5 January</b></li></ul></p>
<hr>
<h2 style="color: rgb(0, 0, 0) !important; font-size: 16px;" data-ogsc="rgb(0, 0, 0)">Our festive opening hours</h2>
<p class="x_content" style="font-size: 16px; color: rgb(0, 0, 0) !important;" data-ogsc="">We will be operating with a reduced number of staff throughout the festive period. We would advise that you only contact us if your query is urgent. To get the latest information, follow us on <a href="https://www.facebook.com/SFEngland/" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-ogsc="" style="color: rgb(0, 0, 0) !important;">Facebook</a> and <a href="https://twitter.com/SF_England" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-ogsc="" style="color: rgb(0, 0, 0) !important;">Twitter</a>.</p>
<hr/>
<p class="x_content" style="font-size: 16px; color: rgb(0, 0, 0) !important;" data-ogsc="">Thanks<br>Student Finance England</p>
<img src="images/emails/studentfinancefooter1.png" width="650" height="100"><p/> <img src="images/emails/studentfinancefooter2.png" width="650" height="100">', 0);

INSERT INTO files (id, filename, content, is_dangerous, action, tooltip_id, icon) VALUES (1, 'bank_details.txt', '<p>Sort code: 11-11-11</p><p>account: 12345678</p><p>card: 0123 4567 8912 3456 expiry: 04/22</p>', 1, '5', 14, 'txt.png');
INSERT INTO files (id, filename, content, is_dangerous, action, tooltip_id, icon) VALUES (2, 'hot.jpg.exe', '', 1, '4', 13, 'jpg.png');
INSERT INTO files (id, filename, content, is_dangerous, action, tooltip_id, icon) VALUES (3, 'passwords.txt', '<table>
	<tr>
	<td>Facebook</td><td>iLoveDogs</td>
	</tr>
	<tr>
	<td>Instagram</td><td>Ihatedos</td>
	</tr>
	<tr>
	<td>Netflix</td><td>catsarebest</td>
	</tr>
	<tr>
	<td>gmail</td><td>yaycats</td>
	</tr>
	<tr>
	<td>Online Banking</td><td>yaycats</td>
	</tr>
</table>', 1, '5', 14, 'txt.png');
INSERT INTO files (id, filename, content, is_dangerous, action, tooltip_id, icon) VALUES (4, 'README.txt', '<p>Many types of computer files can be harmful to your computer.</p>
<p>Your Anti Virus software will detect most harmful files but should be used as the last line of defense. The best protection is to understand the risks and threats so you can avoid them.</p>', 0, '1', 10, 'txt.png');
INSERT INTO files (id, filename, content, is_dangerous, action, tooltip_id, icon) VALUES (5, 'schedule.pif', '', 1, '3', 12, 'noicon.png');
INSERT INTO files (id, filename, content, is_dangerous, action, tooltip_id, icon) VALUES (6, 'vacation1.jpg', '<img class="img-fluid m-0 p-0" src="images/vacation1.jpg" alt="vacation photo 1">', 0, '1', 15, 'jpg.png');
INSERT INTO files (id, filename, content, is_dangerous, action, tooltip_id, icon) VALUES (7, 'vacation2.jpg', '<img class="img-fluid" src="images/vacation2.jpg" alt="vacation photo 1">', 0, '1', 15, 'jpg.png');
INSERT INTO files (id, filename, content, is_dangerous, action, tooltip_id, icon) VALUES (8, 'wages.xlsx', '<table>
	<tr>
	<td>John</td><td>&pound;29,000</td>
	</tr>
	<tr>
	<td>Sally</td><td>&pound;30,000</td>
	</tr>
	<tr>
	<td>Judith</td><td>&pound;35,000</td>
	</tr>
	<tr>
	<td>Thomas</td><td>&pound;25,000</td>
	</tr>
	<tr>
	<td>Richard</td><td>&pound;21,000</td>
	</tr>
	<tr>
	<td>Harold</td><td>&pound;35,000</td>
	</tr>
</table>', 1, '2', 11, 'xls.png');