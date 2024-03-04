سلام <b>{{ $firstname }}</b>، ساعت کاری <b>{{ $month }}</b> ماه در سال <b>{{ $year }}</b> با  کسر جمعه و تعطیلات رسمی <b>{{ $totalhours }}</b> ساعت می‌باشد.

پایه حقوق : <b>{{ $approvedsalary }}</b> میلیون  تومان در <b>{{ $month }}</b> ماه 
حقوق هر ساعت کاری در این ماه : :<b>{{ $hourssalary }}</b> تومان برای هر ساعت کار کرد شما در <b>{{ $month }}</b> ماه
ساعت کارکرد شما : <b>{{ $totalworkinghours }}</b> ساعت در <b>{{ $month }}</b> ماه 

حقوق این ماه شما مبلغ : <b>{{ $salary }}</b> تومان برای ماه <b>{{ $month }}</b> خواهد بود


جدول کلی ورود و خروج شما به شرح زیر است

<x-draw-table :headers="$table['header']" :rows="$table['rows']"></x-draw-table>