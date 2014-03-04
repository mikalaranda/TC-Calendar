
<table>

    <!-- Here is where we loop through our $posts array, printing out post info -->

    <?php foreach ($google_calendars as $event): ?>
    <tr>
        <td><?php echo $event['GoogleCalendar']['id']; ?></td>
        <td><?php echo $event['GoogleCalendar']['url']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>