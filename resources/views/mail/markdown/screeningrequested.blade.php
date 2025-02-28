@component('mail::message')
# Hi {{ $notifiable->name }},

We are thrilled to receive your Profile for screening.

Here are the STEPS for SCREENING:

<strong>STEP 1:</strong> We will review your Tiny Steps Profile.

<strong>STEP 2:</strong> Submit a copy of the following documents for Verification through <a href="mailto:screening@tinysteps.nl">screening@tinysteps.nl </a>:

<ol type="a">
	<li>Valid Proof of Identity (required)
		<ul>
			<li>For EU or EEA citizens - copy of passport/ identity card or driving licence</li>
			<li>For Residents of The Netherlands - copy of the residence permit or Verblijfsvergunning ID/ valid Dutch driving licence</li>
		</ul>
	</li>
	<li>Valid VOG / Certificate of Good Conduct (if any)</li>
	<li>Valid EHBO Certificate or EHBO ID (if any)</li>
	<li>Early Childhood Education Diploma or Childcare Qualification Certificate/ Workshops (if any)</li>
	<li> Other credentials related to childcare</li>
</ol> 

<strong>FOR YOUR PRIVACY & SECURITY:</strong>

<ul>
	<li>Cross out/hide your passport number, date of birth and citizen service number (BSN) in all the documents to be submitted.</li>
	<li>Watermark all documents: “<strong>Tiny Steps, Screening, Date of Copy</strong>”</li>
	<!-- <li>Creating your secure email account takes less than 2 minutes.</li>
	<li>Go to this link to create a Free Protonmail account. <a href="https://mail.protonmail.com/create/new?language=en">https://mail.protonmail.com/create/new?language=en</a></li>
	<li>Send  documents to <a href="mailto:screening.tinysteps@protonmail.com"></a>screening.tinysteps@protonmail.com</li> -->
</ul>  

<strong>STEP 3:</strong> Once all documents are verified, we will call you for an interview.

<strong>STEP 4:</strong> We will notify you through your email and on your status notification box found on your Tiny Steps Profile Page regarding the status of your screening.. 

<strong>STEP 5:</strong> : If you successfully pass the screening, your Profile will be published in the list of Sitters and you’ll have the Tiny Steps Verified Badge 

Goodluck! We are looking forward to you being part of the Tiny Steps family. <br><br>

With joy and love,<br>
{{ config('app.name') }} Team

<p style="text-align: center; margin-top: 30px;">Get in touch if you have any questions, we are here to help.</p>
<p style="text-align: center; color:#2DA65D;"><strong>Send Message</strong><br /><a href="mailto:screening@tinysteps.nl"><strong>screening@tinysteps.nl</strong></a></p>

@endcomponent 




