from functools import cache

with open("input.txt", "r") as f:
    file = f.read().splitlines()

    points = [[int(coord) for coord in line.split(",")] for line in file]


def part2():
    max_area = 0

    iCount = len(points)
    for i, p1 in enumerate(points[:-1]):
        print(f"{i+1} / {iCount}")
        for p2 in points[i+1:]:
            area = calc_area(p1, p2)
            if area > max_area and is_valid_rectangle(p1, p2):
                max_area = area

    print(max_area)


def is_valid_rectangle(p1, p2) -> bool:
    x1, y1 = p1
    x2, y2 = p2

    for x in range(min(x1, x2), max(x1, x2)+1):
        if not is_inside(x, y1) or not is_inside(x, y2):
            return False

    for y in range(min(y1, y2), max(y1, y2)+1):
        if not is_inside(x1, y) or not is_inside(x2, y):
            return False

    return True


@cache
def is_inside(x, y) -> bool:
    bound = [False]*4
    for p1, p2 in zip([points[-1]] + points[:-1], points):
        x1, y1 = p1
        x2, y2 = p2

        if min(x1, x2) <= x <= max(x1, x2):
            if y >= min(y1, y2):
                bound[0] = True
            if y <= max(y1, y2):
                bound[1] = True

        if min(y1, y2) <= y <= max(y1, y2):
            if x >= min(x1, x2):
                bound[2] = True
            if x <= max(x1, x2):
                bound[3] = True

        if all(bound):
            return True

    return False


def calc_area(p1, p2):
    x1, y1 = p1
    x2, y2 = p2

    return (abs(x2-x1)+1) * (abs(y2-y1)+1)


if __name__ == '__main__':
    part2()
