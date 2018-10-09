# kanboard-backlog
Plugin to add a backlog column with full height to project board

To test you have to download the repo into the kanboard plugins folder. Make sure the name of the foler is "Backlog". Make sure you don't use the bigboard (https://github.com/stinnux/kanboard-bigboard) at the moment!

Then create a board and name the first (!) swimlane "backlog" and the first (!) column also "backlog".

If you change an existing board, make sure that there are only tasks in the first column in the first swimlane and that there are no tasks in the first column in all other swimlanes.

Most of it works. The only problem is that this way collapsing the columns does not work completely for the main area (columns that are NOT the backlog) and not at all for my new column backlog. The reason is that to make everything work I had to create 2 <td>-columns in the main table, each with its own sub-table.

![board-with-backlog-column](https://user-images.githubusercontent.com/7022827/45942482-ddd46b00-bfe2-11e8-8655-4cbfde066a1a.png)

In a further step we need to make sure the column folding works even for the backlog column.
