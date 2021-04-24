import java.util.Scanner;
/*
Programmer: Jonathan Petani
Date: 4/24/2021
Purpose: Find the 2 Sum of a Int Target From The Values Inside an Array. Prints The Indices of The 2 Array Elements That Add Up To That 2 Sum
User Can Define Array To Be Used including Size and Elements Inside. Also can Elect to Do Another 2 Sum If They Wish
*/
public class sumclass {
	public static void main(String[] args) {
		//All The Main Variables + Objects Used
		int[] nums;
		int index1 = -1;
		int index2 = -1;
		char cont = ' ';
		int size = 0;
		int target = 0;
		Scanner stdin = new Scanner(System.in);
		do {
			//set indices to default false
			index1 = -1;
			index2 = -1;
			System.out.println("This Program Returns Array Indices of the Two Array Elements That Add Up To The Target Int You Provide.");
			System.out.print("To Start, How Big Should This Array Be? Size 2 Minimum: ");
			size = stdin.nextInt();
			//check for size under 2 (can't do a 2 sum with only one int value)
			if (size <= 1) {
				System.out.println("Size 0 or Below Is Not Allowed;");
				cont = 'Y';
				continue;
			}
			//Create Array in Method and Clone it to the Array Nums in Main Based on Params Desired
			nums = buildNums(size).clone();
			System.out.print("Enter a Integer Target. The Program Will Work To See Which Sum of 2 Array Elements Equals The Target And Return Those Element's Indices: ");
			target = stdin.nextInt();
			//Analyize nums to see if a 2 sum to the input target int can be found. If found break loop to save time
			for(int i = 0; i < nums.length; i++) {
				for(int j = 0; j < nums.length; j++) {
					//make sure index comparison is not of one index itself only
					if(nums[i] == nums[j]) {
						continue;
					}
					if(nums[i] + nums[j] == target) {
						index1 = i;
						index2 = j;
						break;
					}
				}
				if(index1 != -1 && index2 != -1)
					break;
			}
			System.out.print("{");
			//print array for viewing
			for(int i = 0; i < nums.length; i++)
				System.out.print("Index: " + i + " Value: " + nums[i]);
			System.out.print("}");
			//if search is success, show results, otherwise notify failure to find 2 sum
			if(index1 != -1 && index2 != -1) {
				System.out.println("2 Sum for Target Found!");
				System.out.println("Array Indices{ Index 1: " + index1 + " Index 2: " + index2);
				System.out.println(nums[index1] + " + " + nums[index2] + " = " + target);
			}
			else
				System.out.println("No Set of 2 Indices Could Make Up The 2 Sum of Target " + target);
			//prompt to go again
			System.out.print("Would you like to try again with a new array and target? Enter y (or Y) for yes or anything else for no: ");
			cont = stdin.next().charAt(0);
		}while(cont == 'y' || cont == 'Y');
	}
	/**
	*Create Array based on desired size. User decides by prompt which elements to add
	*@param array size
	*@return the new Array to use in the 2 sum problem
	*/
	public static int[] buildNums(int size) {
		int[] newNums = new int[size];
		Scanner stdin_insert = new Scanner(System.in);
		System.out.println("Second Step, Fill In The Array Elements You Wish To Use");
		//prompt user for an int for each element in new array
		for(int i = 0; i < newNums.length; i++) {
			System.out.print("Select Element Value For Index " + i + ": ");
			newNums[i] = stdin_insert.nextInt();
		}
		return newNums;
	}
}