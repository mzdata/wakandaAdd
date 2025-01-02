#!\usr\bin\perl -w
use Net::SMTP;

sub send_content_mail($$$)
{
    my $to_mail = shift;
    my $subject = shift;
    my $content = shift;
    $smtp = Net::SMTP->new('127.0.0.1');    #邮件服务器地址
    $smtp->mail('stat@meilishuo.com');                 #发件人
    $smtp->to($to_mail);
    $smtp->data();
    $smtp->datasend("From: <stat\@meilishuo.com>\n");
    $smtp->datasend("To: ".$to_mail."\n" );

    $smtp->datasend("Subject: ".$subject."\n");   #主题

    $smtp->datasend($content."\n");
    $smtp->dataend();
    $smtp->quit;
}

send_content_mail("wenjiezeng\@meilishuo.com","testpl","testplcontent");
