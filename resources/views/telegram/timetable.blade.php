سلام <b>{{ $firstname }}</b>، ساعت کاری <b>{{ $month }}</b> ماه در سال <b>{{ $year }}</b> با  کسر جمعه و تعطیلات رسمی <b>{{ $totalhours }}</b> ساعت می‌باشد.

پایه حقوق : <b>{{ $salary }}</b> میلیون  تومان در <b>{{ $month }}</b> ماه 
ساعت کاری : <b>{{ $totalhours }}</b> ساعت در <b>{{ $month }}</b> ماه 
حقوق بر اساس ساعت : :<b>{{ $hourssalary }}</b> تومان برای هر ساعت کار کرد شما در <b>{{ $month }}</b> ماه


جدول کلی ساعات موظف کاری به شرح زیر است

<x-draw-table :headers="$table['header']" :rows="$table['rows']"></x-draw-table>