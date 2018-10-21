var
	list		= document.getElementById('categories_switcher'),
	list_length	= list.length,
	counter		= 0

document.getElementById('categories_switcher').onchange = function()
{
	
}

do
{
	with(list.options[counter])
	{
		if(value === '183') // spozywcze
		{
			selected = true
		}
		
		onclick = function()
		{
			location.pathname = '/category/' + this.parentNode.options[this.parentNode.selectedIndex].value
		}
	}
}
while(counter++ < list_length)