@extends('layouts.layout')

@section('content')
	<div class="container wrapper pad50">
		<div class="row">
			<div class="col-12">
				<h2>Email previews</h2>
			</div>
			
			<ul>				
				<li class="padTB5">
					<a href="notification/admin-activated">Admin Activated</a> - Sent to a user when the admin activated the account from the user's tab in the admin dashboard.
				</li>
				<li class="padTB5">
					<a href="notification/admin-blocked">Admin Blocked</a> - Sent to a user when the admin blocked the account from the user's tab in the admin dashboard.
				</li>
				<li class="padTB5">
					<a href="notification/admin-deleted">Admin Deleted</a> - Sent to a user when the admin deleted the account from the user's tab in the admin dashboard.
				</li>
				<li class="padTB5">
					<a href="notification/admin-suspended">Admin Suspended</a> - Sent to a user when the admin suspends the account from the user's tab in the admin dashboard.
				</li>
				<li class="padTB5">
					<a href="notification/cancelled-subscription">Canceled Subscription</a> - Sent to a user when he canceled his premium subscription from the accounts settings page.
				</li>
				<li class="padTB5">
					<a href="notification/account-deactivated">User Deactivated</a> - Sent to a user when he deactivated his account from the account settings page.
				</li>
				<li class="padTB5">
					<a href="notification/goodbye-customer">User Deleted</a> - Sent to a user when he deleted from the accounts settings page.
				</li>
				<li class="padTB5">
					<a href="notification/inactive-deleted">User Deleted (Inactive)</a> - Sent to a user when his/her account was automatically deleted from the system due to un-updated profile after 7 days from account creation.
				</li>
				<li class="padTB5">
					<a href="notification/mentor-account-created">Mentor Account Created</a> - Sent to the user when the admin created the mentor account.
				</li>
				<li class="padTB5">
					<a href="notification/new-message">New Message</a> - Notification email for the chat/messaging.
				</li>
				<li class="padTB5">
					<a href="notification/payment-reminder-ideal">Payment Reminder Ideal</a> - Sent to an Ideal premium user if the current day is 14 days from his current subscription end date.
				</li>
				<li class="padTB5">
					<a href="notification/premium-membership-ideal-nanny">Premium Membership Ideal - Nanny</a> - Sent to a nanny user who bought premium membership via Ideal.
				</li>
				<li class="padTB5">
					<a href="notification/premium-membership-ideal-parent">Premium Membership Ideal - Parent</a> - Sent to a parent user who bought premium membership via Ideal.
				</li>
				<li class="padTB5">
					<a href="notification/premium-renewal-ideal-nanny">Premium Membership Renewal Ideal - Nanny</a> - Sent to a nanny user whose premium membership was renewed via SEPA Debit.
				</li>
				<li class="padTB5">
					<a href="notification/premium-renewal-ideal-parent">Premium Membership Renewal Ideal - Parent</a> - Sent to a parent user whose premium membership was renewed via SEPA Debit.
				</li>
				<li class="padTB5">
					<a href="notification/premium-membership-card-nanny">Premium Membership Card - Nanny</a> - Sent to a nanny user who bought premium membership via card.
				</li>
				<li class="padTB5">
					<a href="notification/premium-membership-card-parent">Premium Membership Card - Parent</a> - Sent to a parent user who bought premium membership via card.
				</li>
				<li class="padTB5">
					<a href="notification/unpaid-membership">Unpaid Membership Ideal</a> - Sent to an Ideal premium user if the renewal charge request failed.
				</li>
				<li class="padTB5">
					<a href="notification/upcoming-invoice">Upcoming Invoice</a> - Sent to a card premium user when Stripe is about to automatically renew the subscription.
				</li>
				<li class="padTB5">
					<a href="notification/verify-email">Verify Email</a> - Sent to a newly registered user for email verification.
				</li>
				<li class="padTB5">
					<a href="notification/vetting-requested">Vetting Requested</a> - Sent to a nanny who requested for vetting.
				</li>
				<li class="padTB5">
					<a href="notification/vetting-cancelled">Vetting Cancelled</a> - Sent to a nanny who cancelled request for vetting.
				</li>
				<li class="padTB5">
					<a href="notification/vetting-passed">Vetting Passed</a> - Sent to a nanny who passed vetting by admin.
				</li>
				<li class="padTB5">
					<a href="notification/vetting-failed">Vetting Failed</a> - Sent to a nanny who failed vetting by admin.
				</li>
				<li class="padTB5">
					<a href="notification/screening-requested">Screening Requested</a> - Sent to a nanny who requested for Screening.
				</li>
				<li class="padTB5">
					<a href="notification/screening-processing">Screening Processing</a> - Sent to a nanny when admin process request for Screening.
				</li>
				<li class="padTB5">
					<a href="notification/screening-passed">Screening Passed</a> - Sent to a nanny who passed Screening by admin.
				</li>
				<li class="padTB5">
					<a href="notification/screening-failed">Screening Failed</a> - Sent to a nanny who failed Screening by admin.
				</li>
			</ul>
		</div>
	</div>
@endsection